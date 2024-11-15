<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelPastBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-past-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy các lịch đặt có ngày đặt lịch đã qua mà vẫn ở trạng thái không phải "Đã hủy"
        $pastBookings = ServiceBooking::where('status', '!=', 'Cancelled')
                                      ->whereDate('booking_date', '<', now()->toDateString())
                                      ->get();

        foreach ($pastBookings as $booking) {
            $booking->update(['status' => 'Cancelled']);
        }

        $this->info('Quá trình hủy tự động hoàn tất.');
    }

}
