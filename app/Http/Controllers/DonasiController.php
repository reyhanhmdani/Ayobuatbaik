<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $programDonasi = ProgramDonasi::findOrFail($programDonasiId);
        $snapToken = null;

        DB::transaction(function () use ($request, $programDonasi, &$snapToken) {
            $donation = Donation::create([
                'donation_code' => 'DON-' . date('YmdHis') . '-' . rand(1000, 9999),
                'program_donasi_id' => $programDonasi->id,
                'donor_name' => $request->donor_name,
                'donor_phone' => $request->donor_phone,
                'donor_email' => $request->donor_email,
                'donation_type' => $request->donation_type,
                'amount' => $request->amount,
                'note' => $request->note,
            ]);

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

            $snapToken = Snap::getSnapToken($payload);
            $donation->update(['snap_token' => $snapToken]);
        });

        return response()->json([
            'snap_token' => $snapToken,
        ]);
    }

    public function notification(Request $request)
    {
        $notif = new Notification();
        DB::transaction(function () use ($notif) {
            $status = $notif->transaction_status;
            $orderId = $notif->order_id;

            $donation = Donation::where('donation_code', $orderId)->firstOrFail();

            if ($status === 'capture' || $status === 'settlement') {
                $donation->setStatusSuccess();

                $donation->program->increment('collected_amount', $donation->amount);
            } elseif ($status === 'pending') {
                $donation->setStatusPending();
            } elseif ($status === 'deny' || $status === 'cancel') {
                $donation->setStatusFailed();
            } elseif ($status === 'expire') {
                $donation->setStatusExpired();
            }
        });

        return response()->json(['message' => 'OK']);
    }
}
