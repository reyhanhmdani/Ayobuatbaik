<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Kirim reminder WA setiap 10 menit
        $schedule->command('donations:send-reminders')
            ->everyTenMinutes()
            ->withoutOverlapping()
            ->runInBackground();

        // Auto-expire donasi setiap jam
        $schedule->command('donations:auto-expire')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground();

        // Hapus donasi failed setiap hari jam 1 pagi
        $schedule->command('donations:delete-failed')
            ->dailyAt('01:00')
            ->withoutOverlapping();

        // Hapus donasi expired setiap hari jam 2 pagi
        $schedule->command('donations:delete-expired')
            ->dailyAt('02:00')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
