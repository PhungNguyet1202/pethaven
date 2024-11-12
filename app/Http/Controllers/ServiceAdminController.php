<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\servicebooking;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use App\Models\inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ServiceAdminController extends Controller
{
    public function service(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);
    
        // Tạo truy vấn cơ bản cho Service
        $query = Service::query();
    
        // Áp dụng tìm kiếm theo tên dịch vụ hoặc mô tả nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                
            });
        }
    
        // Lấy kết quả phân trang
        $services = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Trả về kết quả
        return response()->json($services, 200);
    }
    public function getServiceById($id)
        {
            // Tìm sản phẩm theo ID
            $category = service::get()->find($id);
            
            // Kiểm tra xem sản phẩm có tồn tại không
            if (!$category) {
                return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
            }
        
            return response()->json($category, 200);
        }
        public function postServiceAdd(Request $request)
        {
            // Log giá trị request nhận được
            Log::info('Request data for adding service: ', $request->all());
        
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'image' => 'nullable|image|max:2048',
            ]);
        
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->save();
        
            // Đường dẫn lưu ảnh
            $destinationPath = public_path('images/services');
        
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $imgName = "{$service->id}." . $img->getClientOriginalExtension();
                $img->move($destinationPath, $imgName);
                $service->img = $imgName;
                $service->save();
            }
        
            return response()->json(['message' => 'Thêm dịch vụ thành công'], 201);
        }
        
        public function updateService(Request $request, $id)
{
    Log::info("Starting updateService for service ID: $id");
    Log::info('Request data: ', $request->all());

    $request->validate([
        'name' => 'sometimes|required|string',
        'description' => 'nullable|string',
        'price' => 'sometimes|required|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    $service = Service::find($id);
    if (!$service) {
        Log::warning("Service not found for ID: $id");
        return response()->json(['message' => 'Dịch vụ không tồn tại'], 404);
    }

    Log::info('Original Service data: ', $service->toArray());

    $service->name = $request->name ?? $service->name;
    $service->description = $request->description ?? $service->description;
    $service->price = $request->price ?? $service->price;

    $destinationPath = public_path('images/services');

    try {
        if ($request->hasFile('image')) {
            Log::info('img upload detected for service ID: ' . $id);

            $img = $request->file('image');
            if (!$img->isValid()) {
                Log::error('img upload failed for service ID: ' . $id);
                return response()->json(['message' => 'img upload failed'], 400);
            }

            $imgName = "{$service->id}." . $img->getClientOriginalExtension();
            $img->move($destinationPath, $imgName);
            $service->img = $imgName;
            Log::info('img updated successfully for service ID: ' . $id);
        }

        $service->save();
        Log::info('Service updated successfully for service ID: ' . $id);

        return response()->json(['message' => 'Cập nhật dịch vụ thành công'], 200);
    } catch (\Exception $e) {
        Log::error('Failed to update service ID: ' . $id . ' Error: ' . $e->getMessage());
        return response()->json(['message' => 'Cập nhật dịch vụ thất bại', 'error' => $e->getMessage()], 500);
    }
}

        
    
        
    public function deleteService($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Dịch vụ không tồn tại'], 404);
        }
    
        // Xóa hình ảnh nếu có
        if ($service->img && file_exists(public_path('images/services/' . $service->image))) {
            unlink(public_path('images/services/' . $service->img));
        }
    
        // Xóa dịch vụ
        $service->delete();
    
        return response()->json(['message' => 'Xóa dịch vụ thành công'], 200);
    }
    public function serviceBooking(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);
  
        // Tạo truy vấn cơ bản cho ServiceBooking cùng với user, pet, và service
        $query = ServiceBooking::with(['user', 'pet', 'service']);
  
        // Áp dụng tìm kiếm nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_date', 'like', "%{$search}%") // Tìm theo ngày đặt
                  ->orWhere('status', 'like', "%{$search}%")     // Tìm theo trạng thái
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");  // Tìm theo tên người dùng
                  })
                  ->orWhereHas('pet', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");  // Tìm theo tên thú cưng
                  });
            });
        }
  
        // Lấy kết quả phân trang
        $serviceBookings = $query->paginate($perPage, ['*'], 'page', $page);
  
        // Định dạng lại dữ liệu trả về với tên người dùng và tên thú cưng
        $formattedBookings = $serviceBookings->getCollection()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'booking_date' => $booking->booking_date,
                'status' => $booking->status,
                'total_price' => $booking->total_price,
                'user_id' => $booking->user_id,
                'user_name' => $booking->user ? $booking->user->name : null,  // Lấy tên người dùng
                'pet_id' => $booking->pet_id,
                'pet_name' => $booking->pet ? $booking->pet->name : null,    // Lấy tên thú cưng
                'service_id' => $booking->service_id,
                'service_name' => $booking->service ? $booking->service->name : null, // Lấy tên dịch vụ
            ];
        });
  
        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'data' => $formattedBookings,
            'current_page' => $serviceBookings->currentPage(),
            'last_page' => $serviceBookings->lastPage(),
            'per_page' => $serviceBookings->perPage(),
            'total' => $serviceBookings->total(),
        ], 200);
    }
 
   
    public function updateStatusServicebooking(Request $request, $id)
    {
        // Xác thực dữ liệu cho trạng thái
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,confirmed,canceled,success' // Các trạng thái hợp lệ
        ]);

        // Tìm ServiceBooking theo ID
        $serviceBooking = ServiceBooking::find($id);
        if (!$serviceBooking) {
            return response()->json(['message' => 'Service booking not found'], 404); // Trả về lỗi 404 nếu không tìm thấy
        }

        // Cập nhật trạng thái của ServiceBooking
        $serviceBooking->status = $validatedData['status'];
        
        // Lưu thay đổi vào cơ sở dữ liệu
        $serviceBooking->save();

        // Ghi nhận việc cập nhật để kiểm tra nếu cần
        Log::info("Service booking ID {$id} status updated to {$validatedData['status']}");

        // Trả về phản hồi thành công với thông tin ServiceBooking
        return response()->json([
            'message' => 'Service booking status updated successfully',
            'service_booking' => $serviceBooking
        ], 200);
    }
    public function getServiceBookingById($id)
    {
        // Lấy service booking với service name
        $serviceBooking = ServiceBooking::with('service')->find($id);

        // Kiểm tra nếu không tìm thấy bản ghi
        if (!$serviceBooking) {
            return response()->json(['message' => 'Service booking not found'], 404);
        }

        // Định dạng dữ liệu để trả về
        $serviceBookingData = [
            'id' => $serviceBooking->id,
            'booking_date' => $serviceBooking->booking_date,
            'status' => $serviceBooking->status,
            'total_price' => $serviceBooking->total_price,
            'user_id' => $serviceBooking->user_id,
            'user_name' => $serviceBooking->user? $serviceBooking->user->name : null,
            'user_email' => $serviceBooking->user? $serviceBooking->user->email : null,
            'user_phone' => $serviceBooking->user? $serviceBooking->user->phone : null,
            'pet_id' => $serviceBooking->pet_id,
            'pet_name' => $serviceBooking->pet? $serviceBooking->pet->name : null,
            'service_id' => $serviceBooking->service_id,
            'service_name' => $serviceBooking->service ? $serviceBooking->service->name : null, // Lấy tên dịch vụ
        ];

        // Trả về JSON chứa thông tin service booking
        return response()->json($serviceBookingData, 200);
    }
 
}