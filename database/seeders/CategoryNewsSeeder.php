<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryNewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorynews')->insert([
            [
                'name' => 'Sản phẩm cho thú cưng',
                'description' => 'Tất cả các sản phẩm dành cho thú cưng của bạn.',
            ],
            [
                'name' => 'Dịch vụ chăm sóc thú cưng',
                'description' => 'Dịch vụ chăm sóc và nuôi dưỡng thú cưng.',
            ],
            [
                'name' => 'Mẹo chăm sóc thú cưng',
                'description' => 'Các mẹo và hướng dẫn để chăm sóc thú cưng khỏe mạnh.',
            ],
        ]);
    }
}
