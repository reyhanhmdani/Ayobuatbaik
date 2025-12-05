<?php

namespace App\Http\Controllers;

use App\Helpers\Fonnte;
use App\Jobs\AutoExpireDonationJob;
use App\Jobs\SendPendingDonationReminder;
use App\Models\Donation;
use App\Models\ProgramDonasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class DonasiController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function store(Request $request, $programDonasiId)
    {
        try {
            $programDonasi = ProgramDonasi::findOrFail($programDonasiId);

            $snapToken = null;
            $donation = null;

            DB::transaction(function () use ($request, $programDonasi, &$snapToken, &$donation) {
                // 1. CREATE DONATION
                $donation = Donation::create([
                    'donation_code' => 'DON-' . date('YmdHis') . '-' . rand(1000, 9999),
                    'program_donasi_id' => $programDonasi->id,
                    'donor_name' => $request->donor_name,
                    'donor_phone' => $request->donor_phone,
                    'donor_email' => $request->donor_email,
                    'donation_type' => $request->donation_type,
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'status' => 'unpaid',
                ]);

                // 2. MIDTRANS PAYLOAD
                $payload = [
                    'transaction_details' => [
                        'order_id' => $donation->donation_code,
                        'gross_amount' => $donation->amount,
                    ],
                    'customer_details' => [
                        'first_name' => $donation->donor_name,
                        'email' => $donation->donor_email,
                        'phone' => $donation->donor_phone,
                    ],
                    'item_details' => [
                        [
                            'id' => $donation->id,
                            'price' => $donation->amount,
                            'quantity' => 1,
                            'name' => ucwords(str_replace('_', ' ', $donation->donation_type)),
                        ],
                    ],
                ];

                // 3. GET SNAP TOKEN
                try {
                    $snapToken = Snap::getSnapToken($payload);
                } catch (Exception $e) {
                    // Log::error('MIDTRANS ERROR: ' . $e->getMessage());
                    throw new Exception('Gagal membuat snap token. Transaksi dibatalkan.');
                }
                $donation->update(['snap_token' => $snapToken]);
            });

            // 4. CEK KEBERHASILAN ASIGNMENT
            if ($donation === null) {
                throw new Exception('Gagal membuat data donasi. Transaksi dibatalkan.');
            }

            Log::info("Donation {$donation->donation_code} created successfully. Scheduler akan handle auto-expire & reminder.");

            return response()->json([
                'snap_token' => $snapToken,
                'donation_code' => $donation->donation_code,
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'Gagal memproses donasi. Silakan coba lagi.',
                    'error_detail' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function notification(Request $request)
    {
        Log::info('CALLBACK MIDTRANS MASUK:', $request->all());
        $notif = $request->all();

        DB::transaction(function () use ($notif) {
            $status = $notif['transaction_status'];
            $orderId = $notif['order_id'];

            // extract original order_id (remove -R suffix if exist)
            $originalOrderId = explode('-R', $orderId)[0];

            $donation = Donation::where('donation_code', $orderId)
                ->orWhere('donation_code', 'LIKE', $originalOrderId . '%')
                ->firstOrFail();

            if ($donation->status === $status) {
                // Log::info("Skip Callback status {$status} sudah pernah diproses");
                return;
            }

            // 🔥 CEK STATUS LAMA
            $oldStatus = $donation->status;
            // Log::info("Order {$orderId}: Status LAMA = {$oldStatus}, Status BARU = {$status}");

            $phone = preg_replace('/^0/', '62', $donation->donor_phone);
            $programName = $donation->program->title;
            $amount = number_format($donation->amount, 0, ',', '.');

            // ==============================
            // STATUS: SUCCESS / SETTLEMENT
            // ==============================
            if ($status === 'capture' || $status === 'settlement') {
                // HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== 'success') {
                    $donation->setStatusSuccess();
                    $donation->program->increment('collected_amount', $donation->amount);

                    $message = "Assalamualaikum Warahmatullahi Wabarakatuh 🙏
Terima kasih *{$donation->donor_name}* atas donasi Anda.
📌 *Status:* BERHASIL
📌 *Program:* {$programName}
📌 *Nominal:* Rp {$amount}
Semoga Allah membalas semua kebaikan Anda. Aamiin 🤲";
                    Log::info("Mengirim WA SUCCESS ke {$phone}");
                    Fonnte::send($phone, $message);
                }
            }

            // ==============================
            // STATUS: PENDING
            // ==============================
            elseif ($status === 'pending') {
                // 🔥 HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== 'pending') {
                    $donation->setStatusPending();

                    // SendPendingDonationReminder::dispatch($donation->id)->delay(now()->addMinutes(10));

                    Log::info("Status berubah ke PENDING untuk {$donation->donation_code}. Scheduler akan kirim reminder dalam 30 menit.");
                } else {
                    Log::info('Skip WA PENDING - status sudah pending sebelumnya');
                }
            }

            // =========================================
            // 3) EXPIRE / CANCEL / DENY
            // =========================================
            elseif (in_array($status, ['expire', 'cancel', 'deny'])) {
                // ubah status tapi TIDAK mengirim WA
                if ($status === 'expire' && $oldStatus !== 'expired') {
                    $donation->setStatusExpired();
                } elseif ($oldStatus !== 'failed' && $status !== 'expire') {
                    $donation->setStatusFailed();
                }
                Log::info("Status {$orderId} berubah jadi {$status}, TANPA mengirim WA.");
            }
        });

        return response()->json(['message' => 'OK']);
    }

    public function showStatus($donationCode)
    {
        $donation = Donation::with('program')->where('donation_code', $donationCode)->first();

        if (!$donation) {
            abort(404, 'Donasi tidak ditemukan.');
        }

        $recentDonation = Donation::where('program_donasi_id', $donation->program_donasi_id)
            ->whereIn('status', ['success', 'pending', 'failed', 'expired'])
            ->where('id', '!=', $donation->id)
            ->orderBy('status_change_at', 'desc')
            ->limit(10)
            ->get();

        // Cek apakah donasi sudah lebih dari 24 jam (untuk status failed/expired)
        $isDeletable = false;
        if (in_array($donation->status, ['failed', 'expired']) && $donation->status_change_at) {
            $isDeletable = $donation->status_change_at->addSeconds(20)->isPast();
        }

        $snapToken = null;
        if (in_array($donation->status, ['unpaid', 'pending', 'failed']) && !empty($donation->snap_token)) {
            $snapToken = $donation->snap_token;
        }

        return view('pages.donasi.status', compact('donation', 'recentDonation', 'isDeletable', 'snapToken'));
    }
}
