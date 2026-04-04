<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpirePatientCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-patient-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically inactivate patient cards that have reached their validity date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        
        // Find all active patients whose card validity has expired
        $expiredPatients = Patient::where('status', 'active')
            ->whereNotNull('card_validity_date')
            ->where('card_validity_date', '<', $today)
            ->get();

        if ($expiredPatients->count() === 0) {
            $this->info('No expired patient cards found.');
            return Command::SUCCESS;
        }

        // Inactivate all expired cards
        $count = Patient::where('status', 'active')
            ->whereNotNull('card_validity_date')
            ->where('card_validity_date', '<', $today)
            ->update(['status' => 'inactive']);

        $this->info("Successfully inactivated {$count} expired patient card(s).");

        return Command::SUCCESS;
    }
}

