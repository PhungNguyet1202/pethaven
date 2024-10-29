<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    // public function serviceBooking(Request $request)
    // {
    //     // Xác thực dữ liệu đầu vào
    //     $validator = Validator::make($request->all(), [
    //         'pet_id' => 'required|integer|exists:pets,id',
    //         'service_id' => 'required|integer|exists:services,id',
    //         'booking_date' => 'required|date|after_or_equal:today',
    //     ]);
    
    //     // Nếu xác thực thất bại, trả về lỗi
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Xác thực thất bại',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    
    //     // Lấy thông tin người dùng hiện tại
    //     $user = Auth::user();
    
    //     // Kiểm tra xem người dùng đã xác thực chưa
    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'User is not authenticated.'
    //         ], 401);
    //     }
    
    //     // Tạo đặt dịch vụ mới
    //     $booking = ServiceBooking::create([
    //         'user_id' => $user->id, // Kế thừa user_id từ người dùng đã xác thực
    //         'pet_id' => $request->input('pet_id'),
    //         'service_id' => $request->input('service_id'),
    //         'booking_date' => $request->input('booking_date'),
    //         'phone' => $user->phone, // Giả sử có trường phone trong bảng users
    //         'email' => $user->email, // Giả sử có trường email trong bảng users
    //     ]);
        
    //     Log::info('User ID: ' . $user->id);
    //     Log::info('Input Data: ', $request->all());
    
    //     // Trả về xác nhận đặt dịch vụ
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Đặt dịch vụ thành công',
    //         'data' => $booking
    //     ], 201);
    // }
    public function serviceBooking(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'pet_id' => 'required|integer|exists:pets,id',
        'service_id' => 'required|integer|exists:services,id',
        'booking_date' => 'required|date|after_or_equal:today',
    ]);

    // Nếu xác thực thất bại, trả về lỗi
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Xác thực thất bại',
            'errors' => $validator->errors()
        ], 422);
    }

    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();

    // Kiểm tra xem người dùng đã xác thực chưa
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User is not authenticated.'
        ], 401);
    }

    // Tạo đặt dịch vụ mới
    $booking = ServiceBooking::create([
        'user_id' => $user->id,
        'pet_id' => $request->input('pet_id'),
        'service_id' => $request->input('service_id'),
        'booking_date' => $request->input('booking_date'),
        'phone' => $user->phone,
        'email' => $user->email,
    ]);

    // Log dữ liệu booking
    Log::info('Booking Data:', $booking->toArray());

    // Trả về xác nhận đặt dịch vụ
    return response()->json([
        'status' => 'success',
        'message' => 'Đặt dịch vụ thành công',
        'data' => $booking,  // Trả về booking
    ], 200);  // Trả về trạng thái 200 OK
}

    
    
}
