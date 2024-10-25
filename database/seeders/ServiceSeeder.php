<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm các dịch vụ vào cơ sở dữ liệu

        Service::create([
            'name' => 'Chăm sóc thú cưng',
            //'slug' => 'cham-soc-thu-cung',
            'description' => 'Cung cấp dịch vụ chăm sóc toàn diện, bao gồm vệ sinh, tắm rửa, cắt tỉa lông và các dịch vụ khác để đảm bảo thú cưng của bạn luôn sạch sẽ và khỏe mạnh.',
            'details' => json_encode([
                'Tắm và vệ sinh toàn diện' => 'Đảm bảo thú cưng được tắm rửa sạch sẽ bằng các sản phẩm an toàn, phù hợp với loại da và lông của chúng, giúp giữ vệ sinh và ngăn ngừa các bệnh về da.',
                'Cắt tỉa lông chuyên nghiệp' => 'Cung cấp dịch vụ cắt tỉa lông cho chó, mèo theo yêu cầu và xu hướng, giúp thú cưng của bạn luôn gọn gàng, thoải mái, và dễ thương.',
                'Vệ sinh tai và móng' => 'Làm sạch tai và cắt móng đúng cách để đảm bảo thú cưng không bị nhiễm trùng hoặc đau đớn do móng mọc dài.',
                'Massage thư giãn' => 'Dịch vụ massage nhẹ nhàng giúp thú cưng giảm căng thẳng, thúc đẩy lưu thông máu và tạo cảm giác thoải mái, thư giãn.',
                'Kiểm tra và theo dõi sức khỏe' => 'Nhân viên chăm sóc sẽ kiểm tra tổng quan tình trạng sức khỏe của thú cưng, báo cáo kịp thời các dấu hiệu bất thường để chủ có thể xử lý sớm.',
                'Chế độ chăm sóc cá nhân hóa' => 'Mỗi thú cưng đều được chăm sóc theo nhu cầu riêng biệt, đảm bảo phù hợp với thói quen và tình trạng sức khỏe của chúng.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Chăm sóc và huấn luyện',
            //'slug' => 'cham-soc-va-huan-luyen',
            'description' => 'Cung cấp dịch vụ chăm sóc toàn diện và huấn luyện kỹ năng cơ bản, giúp thú cưng của bạn phát triển cả về thể chất và hành vi một cách lành mạnh.',
            'details' => json_encode([
                'Chăm sóc hàng ngày' => 'Thú cưng sẽ được chăm sóc đầy đủ, bao gồm chế độ ăn uống cân bằng, tắm rửa, vệ sinh, và giám sát sức khỏe thường xuyên.',
                'Huấn luyện cơ bản' => 'Cung cấp các khóa huấn luyện cơ bản như ngồi, đứng, đi vệ sinh đúng chỗ.',
                'Phát triển kỹ năng xã hội' => 'Huấn luyện thú cưng cách tương tác tốt với con người và các động vật khác.',
                'Giảm thiểu hành vi không mong muốn' => 'Tập trung vào việc điều chỉnh các hành vi không mong muốn như cắn phá đồ đạc.',
                'Tăng cường hoạt động thể chất' => 'Kết hợp các bài tập vận động, chơi đùa, và huấn luyện.',
                'Huấn luyện theo yêu cầu riêng' => 'Dịch vụ tùy chỉnh theo nhu cầu cụ thể của chủ nhân.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Dịch vụ khách sạn thú cưng',
            //'slug' => 'khach-san-thu-cung',
            'description' => 'Cung cấp dịch vụ lưu trú cao cấp, chăm sóc toàn diện và an toàn cho thú cưng khi bạn vắng nhà.',
            'details' => json_encode([
                'Lưu trú an toàn và thoải mái' => 'Khách sạn thú cưng với không gian thoải mái, sạch sẽ.',
                'Chăm sóc 24/7' => 'Đội ngũ nhân viên giàu kinh nghiệm sẽ theo dõi sức khỏe.',
                'Hoạt động giải trí' => 'Thú cưng sẽ được tham gia các hoạt động vui chơi và tương tác.',
                'Chăm sóc cá nhân' => 'Đảm bảo mỗi thú cưng được chăm sóc riêng biệt.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Thực phẩm và phụ kiện cho thú cưng',
            //'slug' => 'thuc-pham-phu-kien',
            'description' => 'Chuyên cung cấp các sản phẩm thức ăn dinh dưỡng và phụ kiện chất lượng cao.',
            'details' => json_encode([
                'Thức ăn dinh dưỡng' => 'Đa dạng các loại thức ăn từ các thương hiệu uy tín.',
                'Phụ kiện tiện ích' => 'Cung cấp các sản phẩm phụ kiện như giường ngủ, bát ăn.',
                'Tư vấn dinh dưỡng' => 'Đội ngũ chuyên gia sẽ tư vấn chế độ dinh dưỡng.',
                'Đồ chơi phát triển trí tuệ' => 'Các loại đồ chơi giúp thú cưng phát triển trí não.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Chăm sóc lông và làm đẹp',
            //'slug' => 'cham-soc-long-lam-dep',
            'description' => 'Cung cấp các dịch vụ chăm sóc lông, tắm rửa, cắt tỉa chuyên nghiệp.',
            'details' => json_encode([
                'Tắm và vệ sinh toàn diện' => 'Sử dụng các sản phẩm tắm rửa an toàn.',
                'Cắt tỉa lông' => 'Dịch vụ cắt tỉa lông chuyên nghiệp.',
                'Vệ sinh tai và cắt móng' => 'Giữ cho tai và móng luôn sạch sẽ.',
                'Chăm sóc da và lông đặc biệt' => 'Dịch vụ chăm sóc đặc biệt cho thú cưng có vấn đề.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Huấn luyện và điều chỉnh hành vi',
            //'slug' => 'huan-luyen-dieu-chinh-hanh-vi',
            'description' => 'Cung cấp các khóa huấn luyện từ cơ bản đến nâng cao.',
            'details' => json_encode([
                'Huấn luyện cơ bản' => 'Giúp thú cưng học các kỹ năng cơ bản.',
                'Điều chỉnh hành vi không mong muốn' => 'Đào tạo để loại bỏ các hành vi không mong muốn.',
                'Huấn luyện xã hội hóa' => 'Giúp thú cưng làm quen với các vật nuôi và con người khác.',
                'Huấn luyện nâng cao' => 'Cung cấp các khóa huấn luyện cá nhân hóa theo yêu cầu.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Tư vấn dinh dưỡng và chăm sóc',
            //'slug' => 'tu-van-dinh-duong-cham-soc',
            'description' => 'Cung cấp dịch vụ tư vấn về dinh dưỡng và chăm sóc thú cưng.',
            'details' => json_encode([
                'Tư vấn dinh dưỡng' => 'Giúp bạn xây dựng chế độ ăn uống cân bằng.',
                'Chăm sóc theo tình trạng sức khỏe' => 'Đề xuất cách chăm sóc cho thú cưng có bệnh lý.',
                'Hỗ trợ chọn sản phẩm chăm sóc' => 'Gợi ý những sản phẩm tốt nhất.',
                'Chăm sóc thú cưng trong giai đoạn đặc biệt' => 'Tư vấn cách chăm sóc trong các giai đoạn quan trọng.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Service::create([
            'name' => 'Giao lưu và kết nối thú cưng',
            //'slug' => 'giao-luu-ket-noi-thu-cung',
            'description' => 'Tạo cơ hội cho thú cưng giao lưu, gặp gỡ và kết nối với những người bạn mới.',
            'details' => json_encode([
                'Sự kiện giao lưu thú cưng' => 'Tham gia các buổi gặp gỡ thú cưng.',
                'Ngày hội chăm sóc thú cưng' => 'Các sự kiện đặc biệt bao gồm tư vấn chăm sóc.',
                'Hội thi và trò chơi' => 'Tham gia các cuộc thi dành cho thú cưng.',
                'Kết nối cộng đồng' => 'Tham gia các cộng đồng thú cưng.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
