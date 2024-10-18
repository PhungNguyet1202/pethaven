<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dsSP=[
            
            [
                "name"=> "Áo len xám",
                "image"=> "sp1.jpg",
                "instock"=>rand(10,100),
                "category_id"=>1,
                "price"=>75000,
                "sale_price"=> 50000
            ],
            [
                "name"=> "Ball on rope toy",
                "image"=> "sp2.jpg",
                "instock"=>rand(10,100),
                "category_id"=>5,
                "price"=>80000,
                "sale_price"=> 50000
            ],
            [
                "name"=> "Blue ball for dog",
                "image"=> "sp3.jpg",
                "instock"=>rand(10,100),
                "category_id"=>5,
                "price"=>32000,
                "sale_price"=> 29000
            ],
            [
                "name"=> "Hạt reflex cho chó",
                "image"=> "sp4.jpg",
                "instock"=>rand(10,100),
                "category_id"=>2,
                "price"=>520000,
                "sale_price"=> 500000
            ],
            [
                "name"=> "Interactive toy",
                "image"=> "sp5.jpg",
                "instock"=>rand(10,100),
                "category_id"=>5,
                "price"=>350000,
                "sale_price"=> 250000
            ], [
                "name"=> "Lysine tự nhiên cho thú cưng",
                "image"=> "sp6.jpg",
                "instock"=>rand(10,100),
                "category_id"=>3,
                "price"=>130000,
                "sale_price"=> 100000
            ],
            [
                "name"=> "Multicolored rope",
                "image"=> "sp7.jpg",
                "instock"=>rand(10,100),
                "category_id"=>5,
                "price"=>75000,
                "sale_price"=> 50000
            ],
            [
                "name"=> "Multispot pet food",
                "image"=> "sp8.jpg",
                "instock"=>rand(10,100),
                "category_id"=>3,
                "price"=>750000,
                "sale_price"=> 500000
            ],
            [
                "name"=> "Pet food bowels",
                "image"=> "sp9.jpg",
                "instock"=>rand(10,100), 
                "category_id"=>2,  
                "price"=>420000,
                "sale_price"=> 200000
            ],
            [
                "name"=> "Pik thực phẩm tự nhiên",
                "image"=> "sp10.jpg",
                "instock"=>rand(10,100),
                "category_id"=>3,
                "price"=>300000,
                "sale_price"=> 250000
            ],
            [
                "name"=> "Thức ăn cho chó",
                "image"=> "sp11.jpg",
                "instock"=>rand(10,100),
                "category_id"=>2,
                "price"=>310000,
                "sale_price"=> 250000
            ],
            [
                "name"=> "Thức ăn đặc biệt",
                "image"=> "sp12.jpg",
                "instock"=>rand(10,100),
                "category_id"=>2,
                "price"=>750000,
                "sale_price"=> 500000
            ],
            [
                "name"=> "Toy for pets",
                "image"=> "sp13.jpg",
                "instock"=>rand(10,100),
                "category_id"=>5,
                "price"=>450000,
                "sale_price"=> 250000
            ]
          
            
        
            ];
      foreach($dsSP as $sp){
        Product::create([
            "name" => $sp['name'],
            "slug"=>  Str::slug($sp['name']),
            "image"=>$sp['image'],
            "instock"=>$sp['instock'],
            "category_id"=>$sp['category_id'],
            "price"=>$sp['price'],
            "sale_price"=> $sp['sale_price'],
            
        ]);
      }
    }
}
