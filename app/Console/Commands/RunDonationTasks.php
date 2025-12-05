<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

  class RunDonationTasks extends Command
  {
      protected $signature = 'donations:run-all';
      protected $description = 'Run semua donation tasks (reminders + auto-expire)';

      public function handle()
      {
          $this->info('🚀 Running all donation tasks...');
          $this->newLine();

          // 1. Send Reminders
          $this->info('📧 Sending reminders...');
          $this->call('donations:send-reminders');
          $this->newLine();

          // 2. Auto Expire
          $this->info('⏰ Auto-expiring donations...');
          $this->call('donations:auto-expire');
          $this->newLine();

          $this->info('⏰ Auto-delete donations failed...');
          $this->call('donations:delete-failed');
          $this->newLine();

          $this->info('✅ All tasks completed!');
          
          return 0;
      }
  }