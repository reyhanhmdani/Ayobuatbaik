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

        // 🔥 LOG: Start Check
        Log::info("Auto-Expire Command START", [
            "now" => now()->toDateTimeString(),
        ]);

        $expireDonations = Donation::whereIn("status", ["unpaid", "pending"])
            ->where("expires_at", "<=", now())
            ->get();

        Log::info("Auto-Expire Command QUERY", [
            "total_found" => $expireDonations->count(),
            "donations" => $expireDonations
                ->map(function ($d) {
                    return [
                        "code" => $d->donation_code,
                        "created_at" => $d->created_at->toDateTimeString(),
                        "expires_at" => $d->expires_at,
                        "age" => $d->created_at->diffForHumans(),
                    ];
                })
                ->toArray(),
        ]);

        if ($expireDonations->isEmpty()) {
            $this->info("✅ No donations to expire.");
            Log::info("Auto-Expire: Tidak ada donasi yang perlu di-expire");
            return 0;
        }

        foreach ($expireDonations as $donation) {
            $donation->update([
                "status" => "expired",
                "status_change_at" => now(),
            ]);

            $this->line("⏰ Expired: {$donation->donation_code}");
            Log::info("Auto-Expire: Donation expired", [
                "donation_code" => $donation->donation_code,
                "expired_at" => now(),
            ]);
        }

        return 0;
    }
}
