<?php

namespace App\Jobs;

use App\Models\Donation;
use App\Helpers\Fonnte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SendPendingDonationReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function uniqueId()
    {
        return $this->donationId;
    }

    public $donationId;

    public function __construct($donationId)
    {
        $this->donationId = $donationId;
    }

    public function handle()
    {
        $donation = Donation::find($this->donationId);

        if (!$donation) {
            Log::info("Reminder Job: Donation ID {$this->donationId} tidak ditemukan (mungkin sudah dihapus)");
            return;
        }

        if (!in_array($donation->status, ['pending'])) {
            Log::info("Reminder Job: Donation {$donation->donation_code} sudah {$donation->status}, skip reminder");
            return; 
        }

        $phone = preg_replace("/^0/", "62", $donation->donor_phone);
        $programName = $donation->program->title;
        $amount = number_format($donation->amount, 0, ",", ".");

        $url = route("donation.status", $donation->donation_code);

        $message = "Assalamualaikum 🙏
Donasi Anda masih *menunggu pembayaran*.
📌 Program: {$programName}
📌 Nominal: Rp {$amount}
Silakan lanjutkan pembayaran:
{$url}
Terima kasih 🙏";

        try {
            Fonnte::send($phone, $message);
            Log::info("Reminder WA terkirim untuk {$donation->donation_code}");
        } catch (\Exception $e) {
            Log::error("Gagal kirim reminder WA: " . $e->getMessage());
        }
    }
}
