<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteFailedDonations extends Command
{
    protected $signature = 'donations:delete-failed';
    protected $description = 'Delete failed or expired donations older than 24 hours.';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subHours(24);

        $deletedCount = Donation::where('status', 'failed')->where('status_change_at', '<', $cutoffTime)->delete();

        $this->info("{$deletedCount} failed donations deleted.");

        return 0;
    }
}
