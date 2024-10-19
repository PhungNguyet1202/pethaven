<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                "name" => "Chăm sóc thú cưng",
                "description" => "Cung cấp dịch vụ chăm sóc toàn diện, bao gồm vệ sinh, tắm rửa, cắt tỉa lông và các dịch vụ khác để đảm bảo thú cưng của bạn luôn sạch sẽ và khỏe mạnh.",
                "price" => 500000, // Set a price for the service
                "img" => 'images/services/care_pets.jpg', // Add your image path here
                "category_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Chăm sóc và huấn luyện",
                "description" => "Cung cấp dịch vụ chăm sóc toàn diện và huấn luyện kỹ năng cơ bản, giúp thú cưng của bạn phát triển cả về thể chất và hành vi một cách lành mạnh.",
                "price" => 700000,
                "img" => 'images/services/training_pets.jpg',
                "category_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Dịch vụ khách sạn thú cưng",
                "description" => "Cung cấp dịch vụ lưu trú cao cấp, chăm sóc toàn diện và an toàn cho thú cưng khi bạn vắng nhà.",
                "price" => 1200000,
                "img" => 'images/services/pet_hotel.jpg',
                "categorys_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Thực phẩm và phụ kiện cho thú cưng",
                "description" => "Chuyên cung cấp các sản phẩm thức ăn dinh dưỡng và phụ kiện chất lượng cao, giúp thú cưng của bạn phát triển khỏe mạnh và luôn vui vẻ.",
                "price" => 300000,
                "img" => 'images/services/pet_food_accessories.jpg',
                "categorys_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Chăm sóc lông và làm đẹp",
                "description" => "Cung cấp các dịch vụ chăm sóc lông, tắm rửa, cắt tỉa chuyên nghiệp, giúp thú cưng của bạn luôn sạch sẽ và xinh đẹp.",
                "price" => 400000,
                "img" => 'images/services/grooming_pets.jpg',
                "category_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Huấn luyện và điều chỉnh hành vi",
                "description" => "Cung cấp các khóa huấn luyện từ cơ bản đến nâng cao, giúp thú cưng của bạn phát triển hành vi tốt và sống vui vẻ, hòa đồng.",
                "price" => 600000,
                "img" => 'images/services/behavior_training.jpg',
                "category_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Tư vấn dinh dưỡng và chăm sóc",
                "description" => "Cung cấp dịch vụ tư vấn về dinh dưỡng và chăm sóc thú cưng, đảm bảo chúng luôn khỏe mạnh và phát triển toàn diện.",
                "price" => 250000,
                "img" => 'images/services/nutrition_care.jpg',
                "category_id" => 6 // Replace with a valid category ID
            ],
            [
                "name" => "Giao lưu và kết nối thú cưng",
                "description" => "Tạo cơ hội cho thú cưng giao lưu, gặp gỡ và kết nối với những người bạn mới qua các sự kiện vui chơi và cộng đồng.",
                "price" => 150000,
                "img" => 'images/services/pet_connection.jpg',
                "category_id" => 6 // Replace with a valid category ID
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                "name" => $service['name'],
                // "slug" => Str::slug($service['name']),
                "description" => $service['description'],
                "price" => $service['price'], // Add price
                "img" => $service['img'], // Add image path
                "category_id" => $service['category_id'], // Add category ID
            ]);
        }
    }
}
