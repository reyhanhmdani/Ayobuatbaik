<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\ProgramDonasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $snapToken = Snap::getSnapToken($payload);
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
            // \Log::error('Donasi Gagal: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());

            // Kembalikan respons error yang user-friendly
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
        $notif = new Notification();
        DB::transaction(function () use ($notif) {
            $status = $notif->transaction_status;
            $orderId = $notif->order_id;

            $donation = Donation::where("donation_code", $orderId)->firstOrFail();

            if ($status === "capture" || $status === "settlement") {
                $donation->setStatusSuccess();

                $donation->program->increment("collected_amount", $donation->amount);
            } elseif ($status === "pending") {
                $donation->setStatusPending();
            } elseif ($status === "deny" || $status === "cancel") {
                $donation->setStatusFailed();
            } elseif ($status === "expire") {
                $donation->setStatusExpired();
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

    public function index(Request $request)
    {
        // 1. Ambil filter dari request
        $filterType = $request->get("type", "all");
        $perPage = 15;

        // 2. Query Donasi
        $donationsQuery = Donation::with("program") // Eager load ProgramDonasi terkait
            ->latest(); // Urutkan dari yang terbaru

        // 3. Terapkan filter berdasarkan Tipe Pembayaran (donation_type)
        if ($filterType !== "all") {
            $allowedTypes = ["Qris"];

            if (in_array($filterType, $allowedTypes)) {
                $donationsQuery->where("donation_type", $filterType);
            }
            // Tambahkan logika jika ingin memfilter Status, misal:
            // if ($filterType === 'success') { $donationsQuery->where('status', 'success'); }
        }

        $donations = $donationsQuery->paginate($perPage);

        // 4. Hitung Statistik untuk Tab
        $stats = [
            "all" => Donation::count(),
            "Qris" => Donation::where("donation_type", "Qris")->count(),
            "Transfer" => Donation::where("donation_type", "Transfer")->count(),
            "Tersebar" => Donation::where("donation_type", "Tersebar")->count(),
        ];

        // 5. Kembalikan view
        return view("admin.donations.index", [
            "donations" => $donations,
            "stats" => $stats,
            "currentType" => $filterType,
        ]);
    }
}
