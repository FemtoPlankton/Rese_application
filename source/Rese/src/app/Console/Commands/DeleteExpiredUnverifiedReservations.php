<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteExpiredUnverifiedReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:delete-expired-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unvariified reservations that have passed their reservation date';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        DB::table('reservations')
            ->whereNull('authenticated_at')
            ->where('date', '<', $today)
            ->delete();

        $this->info('Expired unverified reservations deleted successfully.');
    }
}
