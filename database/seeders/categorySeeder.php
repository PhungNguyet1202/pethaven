<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            "name"=>"Quần Áo",
            "description"=>"Các sản phẩm quần áo thiết kế riêng cho mèo với nhiều kiểu dáng và màu sắc khác nhau. Từ áo khoác ấm áp đến bộ đồ thời trang, giúp mèo của bạn vừa đẹp vừa thoải mái.",
          ]);
          Category::create([
            "name"=>"Thức Ăn",
            "description"=>"Thức ăn chất lượng cao được chế biến đặc biệt cho mèo, bao gồm thức ăn khô, ướt và dinh dưỡng bổ sung",
          ]);
          Category::create([
            "name"=>"Thực Phẩm Sức khỏe",
            "description"=>"Các sản phẩm bổ sung dinh dưỡng và vitamin cần thiết để hỗ trợ sức khỏe mèo. Bao gồm các loại thực phẩm chức năng giúp tăng cường miễn dịch, chăm sóc tiêu hóa và duy trì lông đẹp.",
          ]);
          Category::create([
            "name"=>"Chăm Sóc Thú Cưng",
            "description"=>"Dịch vụ chăm sóc mèo chuyên nghiệp, từ tắm rửa, cắt tỉa lông đến chăm sóc sức khỏe định kỳ.",
          ]);
          Category::create([
            "name"=>"Đồ Chơi Thú Cung",
            "description"=>"Bộ sưu tập đồ chơi đa dạng giúp giải trí và kích thích trí não cho mèo. ",
          ]);
          Category::create([
            "name"=>"Dịch Vụ",
            "description"=>"Dịch vụ chăm sóc thú cưng giúp đảm bảo sức khỏe và hạnh phúc cho mèo của bạn, mang lại sự yên tâm khi để chúng được chăm sóc bởi những chuyên gia tận tâm.",
          ]);
          Category::create([
            "name"=>"Phụ Kiện",
            "description"=>"Các phụ kiện cần thiết cho mèo như vòng cổ, dây xích, chỗ ngủ và khay vệ sinh. Những sản phẩm này không chỉ tiện dụng mà còn mang đến sự thoải mái và an toàn cho mèo của bạn.",
          ]);
         
    }
}
