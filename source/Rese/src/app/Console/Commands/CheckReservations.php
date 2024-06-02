<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reservations and delete those older than 1 hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservations = Reservation::where('time', '<=', now()->subHour())->get();

        foreach ($reservations as $reservation) {
            $reservation->delete();
        }

        $this->info('Old reservations have been deleted successfully.');
    }
}
