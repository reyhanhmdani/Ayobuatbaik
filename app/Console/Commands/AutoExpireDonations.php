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

        // Cari donation yang sudah > 24 jam dan masih unpaid/pending
        $expireDonations = Donation::whereIn('status', ['unpaid', 'pending'])
            ->where('created_at', '<=', now()->subHours(24))
            ->get();

        if ($expireDonations->isEmpty()) {
            $this->info('✅ No donations to expire.');
            Log::info('Auto-Expire: Tidak ada donasi yang perlu di-expire');
            return 0;
        }

        $count = 0;

        foreach ($expireDonations as $donation) {
            // Update status menjadi expired
            $donation->update([
                'status' => 'expired',
                'status_change_at' => now(),
            ]);

            $this->line("⏰ Expired: {$donation->donation_code} - {$donation->donor_name}");
            Log::info("Auto-Expire: {$donation->donation_code} telah di-expire");

            $count++;
        }

        $this->info("\n✅ Total expired: {$count} donations");
        Log::info("Auto-Expire: Berhasil expire {$count} donasi");

        return 0;
    }
}
