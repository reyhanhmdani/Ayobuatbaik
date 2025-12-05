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

class AutoExpireDonationJob implements ShouldQueue
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
            Log::info("Auto-Expire Job: Donation ID {$this->donationId} tidak ditemukan");
            return;
        }

        // Jika setelah delay status masih unpaid/pending → ubah jadi expired
        if (in_array($donation->status, ['unpaid', 'pending'])) {

            Log::info("Auto-Expire Job: Donation {$donation->donation_code} di-expire otomatis");

            $donation->update([
                'status' => 'expired',
                'status_change_at' => now(),
            ]);

            return;
        }       

        Log::info("Auto-Expire Job: Donation {$donation->donation_code} sudah {$donation->status}, skip expire");
    }
}
