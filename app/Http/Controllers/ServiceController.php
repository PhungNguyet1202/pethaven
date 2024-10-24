<?php

namespace App\Http\Controllers;

use App\Models\Service; // Import model Service
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // This method will handle displaying the services page
    public function service()
    {
        // Lấy tất cả các bản ghi từ bảng service
        $services = Service::all(); // Sử dụng Service với chữ "S" viết hoa

        // Truyền dữ liệu tới view
        return view('service.service', compact('services'));
    }
    public function show($id)
{
    $service = Service::findOrFail($id); // Tìm dịch vụ theo ID
    return view('services.show', compact('service')); // Truyền dữ liệu đến view
}

}
