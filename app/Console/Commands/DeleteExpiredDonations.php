<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteExpiredDonations extends Command
{
    protected $signature = 'donations:delete-expired';
    protected $description = 'Delete failed or expired donations older than 24 hours.';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subHours(24);

        // Cari donasi dengan status 'failed' atau 'expired'
        // dan status_change_at kurang dari waktu cut-off (yaitu > 24 jam)
        $deletedCount = Donation::whereIn('status', ['failed', 'expired'])
            ->where('status_change_at', '<', $cutoffTime)
            ->delete();

        $this->info("{$deletedCount} failed/expired donations deleted.");

        return 0;
    }
}
