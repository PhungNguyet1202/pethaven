<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UserAdminController; // Giả sử hàm updateUserStatusBasedOnCancelledOrders nằm trong UserController

class UpdateUserStatus extends Command
{
    protected $signature = 'user:update-status';
    protected $description = 'Update user status based on cancelled orders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Khởi tạo UserController và gọi hàm updateUserStatusBasedOnCancelledOrders
        $controller = new UserAdminController();
        $controller->updateUserStatusBasedOnCancelledOrders();

        $this->info('User statuses updated based on cancelled orders');
    }
}
