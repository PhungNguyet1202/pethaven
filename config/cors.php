<?php

return [

    'paths' => ['api/*', 'admin/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Cho phép tất cả các phương thức HTTP

    'allowed_origins' => ['http://localhost:3000'], // Chỉ định tên miền của React app

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Cho phép tất cả các header

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Đặt thành true nếu bạn cần gửi thông tin xác thực

];