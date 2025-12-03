<?php

namespace App\Jobs;

use App\Helpers\Fonnte;
use App\Models\Donation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SendDonationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $message;
    public $orderId;
    public $expectedStatus;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $message, $orderId, $expectedStatus)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->orderId = $orderId;
        $this->expectedStatus = $expectedStatus;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 🔥 CEK LAGI STATUS SEBELUM KIRIM (untuk pending)
        if ($this->expectedStatus === 'pending') {
            $donation = Donation::where('donation_code', $this->orderId)->first();

            // Jika status masih pending, baru kirim
            if ($donation && $donation->status === 'pending') {
                Fonnte::send($this->phone, $this->message);
                Log::info("Notifikasi PENDING dikirim untuk {$this->orderId}");
            } else {
                Log::info("Status berubah dari pending, notifikasi dibatalkan untuk {$this->orderId}");
            }
        } else {
            // Status selain pending, langsung kirim
            Fonnte::send($this->phone, $this->message);
        }
    }
}
