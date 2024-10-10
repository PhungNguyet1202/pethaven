<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Comment::insert([
        [
           'user_id'=>1,
           'product_id'=>1,
           'content'=>'Rẻ nhưng vải chất lượng nha! Nên mua',
           'rating'=>5,
           'created_at'=>now(),
       ],
       [
        'user_id'=>1,
        'product_id'=>1,
        'content'=>'Mình mua lúc sale, rẻ mà chất lượng',
        'rating'=>4,
        'created_at'=>now(),
    ],
    ]);
    }
}
