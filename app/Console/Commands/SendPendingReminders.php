<?php

namespace App\Console\Commands;

use App\Helpers\Fonnte;
use App\Models\Donation;
use Illuminate\Console\Command;
use Log;

class SendPendingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donations:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Reminder WA untuk donasi pending setelah 30 menit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📱 Checking for pending donations to remind...');

        $pendingDonations = Donation::where('status', 'pending')
            ->whereNull('reminder_sent_at')
            ->where('status_change_at', '<=', now()->subSeconds(10))
            ->get();

        if ($pendingDonations->isEmpty()) {
            $this->info('✅ No pending donations to remind.');
            Log::info('Reminder Command: Tidak ada donasi pending yang perlu reminder');
            return 0;
        }

        $count = 0;

        foreach ($pendingDonations as $donation) {
            $phone = preg_replace('/^0/', '62', $donation->donor_phone);
            $programName = $donation->program->title;
            $amount = number_format($donation->amount, 0, ',', '.');
            $url = route('donation.status', $donation->donation_code);

            $message = "Assalamualaikum Warahmatullahi Wabarakatuh
Yth. Bapak/Ibu Dermawan,
Terima kasih atas niat baik Anda untuk berdonasi. Berikut ini adalah instruksi pembayaran donasi Anda:
Mohon lakukan transfer sesuai nominal berikut :
📌 Nominal: Rp {$amount}
Silakan transfer ke rekening yang telah kami sediakan pada link berikut: {$url}
Pembayaran dapat dilakukan maksimal dalam 1x24 jam. Setelah waktu tersebut, sistem akan otomatis membatalkan donasi Anda.
Jazakumullahu Khairan Katsiran.
Terima kasih atas kebaikan dan kepercayaan Anda.";

            try {
                Fonnte::send($phone, $message);

                // Update reminder_sent_at agar tidak dikirim lagi
                $donation->update(['reminder_sent_at' => now()]);

                $count++;
                Log::info("Reminder Command: WA terkirim untuk {$donation->donation_code}");
                $this->info("📤 Reminder sent: {$donation->donation_code}");
            } catch (\Exception $e) {
                Log::error("Reminder Command: Gagal kirim WA untuk {$donation->donation_code} - {$e->getMessage()}");
                $this->error("❌ Failed: {$donation->donation_code}");
            }
        }

        $this->info("✅ Total reminders sent: {$count}");
        Log::info("Reminder Command: Total {$count} reminder terkirim");

        return 0;
    }
}
