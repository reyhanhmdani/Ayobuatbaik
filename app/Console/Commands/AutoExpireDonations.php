<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;

class AutoExpireDonations extends Command
{
    protected $signature = "donations:auto-expire";
    protected $description = "Auto-expire donations yang sudah melewati batas waktu";

    public function handle()
    {
        $expired = Donation::whereIn("status", ["unpaid", "pending"])
            ->where("expires_at", "<=", now())
            ->update([
                "status" => "expired",
                "status_change_at" => now(),
            ]);

        if ($expired > 0) {
            $this->info("[" . now()->format('Y-m-d H:i') . "] Expired: {$expired} donations");
        }

        return 0;
    }
}

