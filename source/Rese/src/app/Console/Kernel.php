<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function() {
            DB::table('password_resets')->where('created_at', '<', now()->subHours())->delete();
        })->daily();

        $schedule->call(function() {
            DB::table('reservations')->where('time', '<=', now()->subHour(6))->delete();
        })->daily();

        $schedule->call(function() {
            DB::table('reservations')->whereNull('token')->update(['token' => str::random(32)]);
        })->daily();

        $schedule->command('reservation:delete-expired-unverified')->dailyAt('23:59');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
