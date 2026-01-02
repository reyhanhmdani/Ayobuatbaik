<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteFailedDonations extends Command
{
    protected $signature = 'donations:delete-failed';
    protected $description = 'Delete failed donations older than 24 hours';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subHours(24);

        $deletedCount = Donation::where('status', 'failed')
            ->where('status_change_at', '<', $cutoffTime)
            ->delete();

        if ($deletedCount > 0) {
            $this->info("[" . now()->format('Y-m-d H:i') . "] Deleted: {$deletedCount} failed donations");
        }

        return 0;
    }
}

