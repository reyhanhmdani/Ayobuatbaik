<?php

namespace App\Http\Controllers;

use App\Helpers\Fonnte;
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
        Config::$serverKey = config("services.midtrans.serverKey");
        Config::$isProduction = config("services.midtrans.is_production");
        Config::$isSanitized = config("services.midtrans.is_sanitized");
        Config::$is3ds = config("services.midtrans.is_3ds");
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
                    "donation_code" => "DON-" . date("YmdHis") . "-" . rand(1000, 9999),
                    "program_donasi_id" => $programDonasi->id,
                    "donor_name" => $request->donor_name,
                    "donor_phone" => $request->donor_phone,
                    "donor_email" => $request->donor_email,
                    "donation_type" => $request->donation_type,
                    "amount" => $request->amount,
                    "note" => $request->note,
                    "status" => "unpaid",
                ]);

                // 2. MIDTRANS PAYLOAD
                $payload = [
                    "transaction_details" => [
                        "order_id" => $donation->donation_code,
                        "gross_amount" => $donation->amount,
                    ],
                    "customer_details" => [
                        "first_name" => $donation->donor_name,
                        "email" => $donation->donor_email,
                        "phone" => $donation->donor_phone,
                    ],
                    "item_details" => [
                        [
                            "id" => $donation->id,
                            "price" => $donation->amount,
                            "quantity" => 1,
                            "name" => ucwords(str_replace("_", " ", $donation->donation_type)),
                        ],
                    ],
                ];

                // 3. GET SNAP TOKEN
                try {
                    $snapToken = Snap::getSnapToken($payload);
                } catch (Exception $e) {
                    Log::error("MIDTRANS ERROR: " . $e->getMessage());
                    throw new Exception("Gagal membuat snap token. Transaksi dibatalkan.");
                }
                $donation->update(["snap_token" => $snapToken]);
            });

            // 4. CEK KEBERHASILAN ASIGNMENT
            if ($donation === null) {
                throw new Exception("Gagal membuat data donasi. Transaksi dibatalkan.");
            }

            return response()->json([
                "snap_token" => $snapToken,
                "donation_code" => $donation->donation_code,
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    "message" => "Gagal memproses donasi. Silakan coba lagi.",
                    "error_detail" => $e->getMessage(), // Hapus ini di mode production
                ],
                500,
            );
        }
    }

    public function notification(Request $request)
    {
        Log::info("CALLBACK MIDTRANS MASUK:", $request->all());
        $notif = $request->all();

        DB::transaction(function () use ($notif) {
            $status = $notif["transaction_status"];
            $orderId = $notif["order_id"];

            // extract original order_id (remove -R suffix if exist)
            $originalOrderId = explode("-R", $orderId)[0];

            $donation = Donation::where("donation_code", $orderId)
                ->orWhere("donation_code", "LIKE", $originalOrderId . "%")
                ->firstOrFail();

            // 🔥 CEK STATUS LAMA
            $oldStatus = $donation->status;
            Log::info("Order {$orderId}: Status LAMA = {$oldStatus}, Status BARU = {$status}");

            $phone = preg_replace("/^0/", "62", $donation->donor_phone);
            $programName = $donation->program->title;
            $amount = number_format($donation->amount, 0, ",", ".");

            // ==============================
            // STATUS: SUCCESS / SETTLEMENT
            // ==============================
            if ($status === "capture" || $status === "settlement") {
                // HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== "success") {
                    $donation->setStatusSuccess();
                    $donation->program->increment("collected_amount", $donation->amount);

                    $message = "Assalamualaikum 🙏
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
            elseif ($status === "pending") {
                // 🔥 HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== "pending") {
                    $donation->setStatusPending();

                    $url = route("donation.pay", $orderId);
                    $message = "Assalamualaikum 🙏
Donasi Anda *belum diselesaikan*.
📌 *Program:* {$programName}
📌 *Nominal:* Rp {$amount}
Silakan lanjutkan pembayaran untuk menyempurnakan donasi Anda 🤲
{$url}
Terima kasih 🙏";
                    Log::info("Mengirim WA PENDING ke {$phone}");
                    Fonnte::send($phone, $message);
                } else {
                    Log::info("Skip WA PENDING - status sudah pending sebelumnya");
                }
            }

            // ==============================
            // STATUS: EXPIRE
            // ==============================
            elseif ($status === "expire") {
                // 🔥 HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== "expired") {
                    $donation->setStatusExpired();

                    $url = route("donation.pay", $orderId);
                    $message = "Assalamualaikum 🙏
Pembayaran donasi Anda *gagal/kadaluarsa*.
Anda dapat melanjutkan pembayaran di link berikut:
{$url}
Semoga Allah mudahkan urusan Anda 🤲";

                    Fonnte::send($phone, $message);
                }
            }

            // ==============================
            // STATUS: CANCEL / DENY
            // ==============================
            elseif ($status === "deny" || $status === "cancel") {
                // 🔥 HANYA KIRIM JIKA STATUS BERUBAH
                if ($oldStatus !== "failed") {
                    $donation->setStatusFailed();

                    $url = route("donation.pay", $orderId);
                    $message = "Assalamualaikum 🙏
Pembayaran donasi Anda *gagal*.
Silakan lanjutkan pembayaran di link berikut:
{$url}
Semoga Allah mudahkan urusan Anda 🤲";

                    Fonnte::send($phone, $message);
                }
            }
        });

        return response()->json(["message" => "OK"]);
    }

    public function showStatus($donationCode)
    {
        $donation = Donation::with("program")->where("donation_code", $donationCode)->first();

        if (!$donation) {
            return response()->json(["message" => "Donation not found"], 404);
        }

        $recentDonation = Donation::where("program_donasi_id", $donation->program_donasi_id)
            ->whereIn("status", ["success", "pending", "failed", "expired"]) // Tampilkan semua status seperti permintaan Anda
            ->where("id", "!=", $donation->id)
            ->orderBy("status_change_at", "desc")
            ->limit(10)
            ->get();

        // Cek apakah donasi sudah lebih dari 24 jam (hanya untuk status gagal/expired)
        $isDeletable = false;
        if (in_array($donation->status, ["failed", "expired"]) && $donation->status_change_at) {
            $isDeletable = $donation->status_change_at->addHours(24)->isPast();
        }
        return view("pages.donasi.status", compact("donation", "recentDonation", "isDeletable"));
    }

    public function pay($donationCode)
    {
        $donation = Donation::where("donation_code", $donationCode)->firstOrFail();

        // Hanya bisa bayar ulang kalau PENDING, FAILED, EXPIRED
        if (!in_array($donation->status, ["unpaid", "pending", "failed", "expired"])) {
            return redirect()->route("donation.status", $donationCode)->with("error", "Donasi ini sudah berhasil atau tidak bisa diproses.");
        }

        // Gunakan Snap Token yang ada
        $snapToken = $donation->snap_token;

        // jika snap token kosong. redirect
        if (empty($snapToken)) {
            return redirect()->route("donation.status", $donationCode)->with("error", "Snap token tidak ditemukan.");
        }

        return view("pages.donasi.pay", compact("donation", "snapToken"));
    }

    // public function index(Request $request)
    // {
    //     // 1. Ambil filter dari request
    //     $filterType = $request->get("type", "all");
    //     $perPage = 15;

    //     // 2. Query Donasi
    //     $donationsQuery = Donation::with("program") // Eager load ProgramDonasi terkait
    //         ->latest(); // Urutkan dari yang terbaru

    //     // 3. Terapkan filter berdasarkan Tipe Pembayaran (donation_type)
    //     if ($filterType !== "all") {
    //         $allowedTypes = ["Qris"];

    //         if (in_array($filterType, $allowedTypes)) {
    //             $donationsQuery->where("donation_type", $filterType);
    //         }
    //         // Tambahkan logika jika ingin memfilter Status, misal:
    //         // if ($filterType === 'success') { $donationsQuery->where('status', 'success'); }
    //     }

    //     $donations = $donationsQuery->paginate($perPage);

    //     // 4. Hitung Statistik untuk Tab
    //     $stats = [
    //         "all" => Donation::count(),
    //         "Qris" => Donation::where("donation_type", "Qris")->count(),
    //         "Transfer" => Donation::where("donation_type", "Transfer")->count(),
    //         "Tersebar" => Donation::where("donation_type", "Tersebar")->count(),
    //     ];

    //     // 5. Kembalikan view
    //     return view("admin.donations.index", [
    //         "donations" => $donations,
    //         "stats" => $stats,
    //         "currentType" => $filterType,
    //     ]);
    // }
}
