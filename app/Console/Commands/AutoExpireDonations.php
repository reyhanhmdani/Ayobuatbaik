<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;
use Log;

class AutoExpireDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donations:auto-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-expire donations yang sudah lebih dari 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking for expired donations...');

        $cutoffTime = now()->subHours(24);

        // 🔥 LOG: Waktu cutoff
        Log::info('Auto-Expire Command START', [
            'now' => now()->toDateTimeString(),
            'cutoff_time' => $cutoffTime->toDateTimeString(),
        ]);

        // Cari donation yang sudah > 24 jam dan masih unpaid/pending
        $expireDonations = Donation::whereIn('status', ['unpaid', 'pending'])
            ->where('expires_at', '<=', now())
            ->update([
                'status' => 'expired',
                'status_change_at' => now(),
            ]);

        // 🔥 LOG: Hasil query
        Log::info('Auto-Expire Command QUERY', [
            'total_found' => $expireDonations->count(),
            'donations' => $expireDonations
                ->map(function ($d) {
                    return [
                        'code' => $d->donation_code,
                        'created_at' => $d->created_at->toDateTimeString(),
                        'age_hours' => $d->created_at->diffInHours(now()),
                    ];
                })
                ->toArray(),
        ]);

        if ($expireDonations->isEmpty()) {
            $this->info('✅ No donations to expire.');
            Log::info('Auto-Expire: Tidak ada donasi yang perlu di-expire');
            return 0;
        }

        $count = 0;

        foreach ($expireDonations as $donation) {
            $donation->update([
                'status' => 'expired',
                'status_change_at' => now(),
            ]);

            $this->line("⏰ Expired: {$donation->donation_code} - {$donation->donor_name} (Age: {$donation->created_at->diffForHumans()})");
            Log::info('Auto-Expire: Donation expired', [
                'donation_code' => $donation->donation_code,
                'created_at' => $donation->created_at->toDateTimeString(),
                'expired_at' => now()->toDateTimeString(),
            ]);

            $count++;
        }

        $this->info("\n✅ Total expired: {$count} donations");
        Log::info("Auto-Expire Command END: Berhasil expire {$count} donasi");

        return 0;
    }
}
