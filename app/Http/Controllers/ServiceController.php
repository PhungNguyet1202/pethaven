<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Lấy danh sách dịch vụ với phân trang
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Số dịch vụ trên mỗi trang, mặc định là 10

        $services = Service::paginate($perPage); // Lấy danh sách dịch vụ với phân trang

        // Trả về dữ liệu dịch vụ dạng JSON
        return response()->json([
            'status' => 'success',
            'data' => $services
        ], 200);
    }

    // Lấy chi tiết dịch vụ theo id hoặc slug
    public function show($identifier)
    {
        // Tìm dịch vụ theo id hoặc slug
        $service = Service::where('id', $identifier)
                      
                          ->first();

        // Nếu không tìm thấy dịch vụ, trả về lỗi 404
        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found'
            ], 404);
        }

        // Trả về thông tin chi tiết dịch vụ dạng JSON
        return response()->json([
            'status' => 'success',
            'data' => $service
        ], 200);
    }

    // Thêm mới dịch vụ
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string|unique:services,slug',
            'price' => 'required|numeric',
        ]);

        // Tạo mới dịch vụ
        $service = Service::create($validatedData);

        // Trả về thông tin dịch vụ mới tạo
        return response()->json([
            'status' => 'success',
            'data' => $service
        ], 201);
    }

    // Cập nhật thông tin dịch vụ
    public function update(Request $request, $id)
    {
        // Tìm dịch vụ cần cập nhật
        $service = Service::find($id);
        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found'
            ], 404);
        }

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'slug' => 'sometimes|required|string|unique:services,slug,' . $service->id,
            'price' => 'sometimes|required|numeric',
        ]);

        // Cập nhật thông tin dịch vụ
        $service->update($validatedData);

        // Trả về thông tin dịch vụ đã cập nhật
        return response()->json([
            'status' => 'success',
'data' => $service
        ], 200);
    }

    // Xóa dịch vụ
    public function destroy($id)
    {
        // Tìm dịch vụ cần xóa
        $service = Service::find($id);
        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found'
            ], 404);
        }

        // Xóa dịch vụ
        $service->delete();

        // Trả về thông báo thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Service deleted successfully'
        ], 200);
    }
}
