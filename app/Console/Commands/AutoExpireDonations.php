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
    protected $signature = "donations:auto-expire";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Auto-expire donations yang sudah lebih dari 24 jam";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 Checking for expired donations...");

        $expireDonations = Donation::whereIn("status", ["unpaid", "pending"])
            ->where("expires_at", "<=", now())
            ->get();

        if ($expireDonations->isEmpty()) {
            $this->info("✅ No donations to expire.");
            return 0;
        }

        foreach ($expireDonations as $donation) {
            $donation->update([
                "status" => "expired",
                "status_change_at" => now(),
            ]);

            $this->line("⏰ Expired: {$donation->donation_code}");
        }

        // Log ringkasan saja
        if ($expireDonations->count() > 0) {
            Log::info("Auto-Expire: {$expireDonations->count()} donasi expired");
        }

        return 0;
    }
}
