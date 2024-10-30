<?php

namespace App\Console;
use App\Http\Controllers\AdminApiController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Tạo một instance của UserStatusController và gọi phương thức cần thiết
            $controller = new AdminApiController();
            $controller->updateUserStatusBasedOnCancelledOrders();
        })->daily(); // Chạy mỗi ngày
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
