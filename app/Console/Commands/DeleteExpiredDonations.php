<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteExpiredDonations extends Command
{
    protected $signature = 'donations:delete-expired';
    protected $description = 'Delete expired donations older than 7 days';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subDays(7);

        $deletedCount = Donation::where('status', 'expired')
            ->where('status_change_at', '<', $cutoffTime)
            ->delete();

        if ($deletedCount > 0) {
            $this->info("[" . now()->format('Y-m-d H:i') . "] Deleted: {$deletedCount} expired donations");
        } else {
            $this->info("[" . now()->format('Y-m-d H:i') . "] Deleted: 0 expired donations");
        }

        return 0;
    }
}
