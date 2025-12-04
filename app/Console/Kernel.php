<?php

namespace App\Console;

use App\Jobs\AutoExpireDonationJob;
use App\Models\Donation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // 1. Expire otomatis setelah 24 jam
        $schedule
            ->call(function () {
                Donation::whereIn('status', ['pending', 'unpaid'])
                    ->where('created_at', '<=', now()->subDay())
                    ->update([
                        'status' => 'expired',
                        'status_change_at' => now(),
                    ]);
            })
            ->everyFiveMinutes();

        // 2. Kirim reminder setelah 10 menit pending
        $schedule
            ->call(function () {
                $donations = Donation::where('status', 'pending')
                    ->where('created_at', '<=', now()->subMinutes(10))
                    ->whereNull('reminder_sent_at')
                    ->get();

                foreach ($donations as $donation) {
                    SendPendingDonationReminder::dispatchSync($donation->id);

                    $donation->update(['reminder_sent_at' => now()]);
                }
            })
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
