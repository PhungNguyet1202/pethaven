<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers; // Đảm bảo dòng này có trong ServiceController
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Pet;
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
    public function getAllPets(Request $request)
    {
        $dsPet = Pet::get();
        if ($dsPet->isEmpty()) {
            return response()->json(['message' => 'No pets found'], 404);
        }
        return response()->json($dsPet, 200);
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
//     public function serviceBooking(Request $request)
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
//         'user_id' => $user->id,
//         'pet_id' => $request->input('pet_id'),
//         'service_id' => $request->input('service_id'),
//         'booking_date' => $request->input('booking_date'),
//         'phone' => $user->phone,
//         'email' => $user->email,
//     ]);

//     // Log dữ liệu booking
//     Log::info('Booking Data:', $booking->toArray());

//     // Trả về xác nhận đặt dịch vụ
//     return response()->json([
//         'status' => 'success',
//         'message' => 'Đặt dịch vụ thành công',
//         'data' => $booking,  // Trả về booking
//     ], 200);  // Trả về trạng thái 200 OK
// }
// public function serviceBooking(Request $request)
// {
//     // Kiểm tra xem người dùng đã xác thực chưa
//     $user = Auth::user();

//     // Định nghĩa các quy tắc xác thực
//     $rules = [
//         'pet_id' => 'required|integer|exists:pets,id',
//         'service_id' => 'required|integer|exists:services,id',
//         'booking_date' => 'required|date|after_or_equal:today',
//     ];

//     // Thêm xác thực cho điện thoại và email nếu người dùng không xác thực
//     if (!$user) {
//         $rules['phone'] = 'required|string|max:15';
//         $rules['email'] = 'required|email';
//     }

//     // Xác thực dữ liệu đầu vào
//     $validator = Validator::make($request->all(), $rules);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Xác thực thất bại',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     // Đặt giá trị điện thoại và email dựa trên trạng thái người dùng
//     $phone = $user ? $user->phone : $request->input('phone');
//     $email = $user ? $user->email : $request->input('email');

//     // Tạo đặt dịch vụ mới
//     $booking = ServiceBooking::create([
//         'user_id' => $user ? $user->id : null, // Sử dụng user_id nếu đã xác thực, ngược lại để null
//         'pet_id' => $request->input('pet_id'),
//         'service_id' => $request->input('service_id'),
//         'booking_date' => $request->input('booking_date'),
//         'phone' => $phone,
//         'email' => $email,
//     ]);

//     // Ghi log dữ liệu đặt
//     Log::info('Dữ liệu đặt:', $booking->toArray());

//     // Trả về xác nhận đặt dịch vụ
//     return response()->json([
//         'status' => 'success',
//         'message' => 'Đặt dịch vụ thành công',
//         'data' => $booking,
//     ], 201);
// }

//booking đc gồi
// public function serviceBooking(Request $request)
// {
//     try {
//         // Kiểm tra người dùng đã xác thực chưa
//         $user = Auth::user();

//         // Định nghĩa quy tắc xác thực
//         $rules = [
//             'pet_id' => 'required|integer|exists:pets,id',
//             'service_id' => 'required|integer|exists:services,id',
//             'booking_date' => 'required|date|after_or_equal:today',
//         ];

//         // Thêm quy tắc cho điện thoại và email nếu người dùng không xác thực
//         if (!$user) {
//             $rules['phone'] = 'required|string|max:15';
//             $rules['email'] = 'required|email';
//         }

//         // Xác thực dữ liệu đầu vào
//         $validator = Validator::make($request->all(), $rules);

//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => 'Xác thực thất bại',
//                 'errors' => $validator->errors()
//             ], 422);
//         }

//         // Gán giá trị cho điện thoại và email
//         $phone = $user ? $user->phone : $request->input('phone');
//         $email = $user ? $user->email : $request->input('email');

//         // Tạo đặt dịch vụ mới
//         $booking = ServiceBooking::create([
//             'user_id' => $user ? $user->id : null,
//             'pet_id' => $request->input('pet_id'),
//             'service_id' => $request->input('service_id'),
//             'booking_date' => $request->input('booking_date'),
//             'phone' => $phone,
//             'email' => $email,
//             'status' => 'pending', // Hoặc trạng thái mặc định nào đó
//             'total_price' => 0, // Hoặc tính toán giá trị thực tế
//         ]);

//         Log::info('Dữ liệu đặt:', $booking->toArray());

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Đặt dịch vụ thành công',
//             'data' => $booking,
//         ], 201);
//     } catch (\Exception $e) {
//         Log::error('Lỗi đặt dịch vụ: ' . $e->getMessage());
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Đã xảy ra lỗi khi đặt dịch vụ.',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

//chưa có giá tiền
// public function serviceBooking(Request $request)
// {
//     Log::info('Request Data: ', $request->all()); // Thêm log này để kiểm tra dữ liệu nhận được
//     try {
//         // Kiểm tra người dùng đã xác thực chưa
//         $user = Auth::user();

//         // Định nghĩa quy tắc xác thực
//         $rules = [
//             'pet_id' => 'required|integer|exists:pets,id',
//             'service_id' => 'required|integer|exists:services,id',
//             'booking_date' => 'required|date|after_or_equal:today',
//         ];

//         if (!$user) {
//             $rules['phone'] = 'required|string|max:15';
//             $rules['email'] = 'required|email';
//         }

//         // Xác thực dữ liệu đầu vào
//         $validator = Validator::make($request->all(), $rules);
//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => 'Xác thực thất bại',
//                 'errors' => $validator->errors()
//             ], 422);
//         }

//         // Gán giá trị cho điện thoại và email
//         $phone = $user ? $user->phone : $request->input('phone');
//         $email = $user ? $user->email : $request->input('email');

//         // Tạo đặt dịch vụ mới
//         $booking = ServiceBooking::create([
//             'user_id' => $user ? $user->id : null,
//             'pet_id' => $request->input('pet_id'),
//             'service_id' => $request->input('service_id'),
//             'booking_date' => $request->input('booking_date'),
//             'phone' => $phone,
//             'email' => $email,
//             'status' => 'pending',
//             'total_price' => 0, // Hoặc tính toán giá trị thực tế
//         ]);

//         Log::info('Dữ liệu đặt:', $booking->toArray());

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Đặt dịch vụ thành công',
//             'data' => $booking,
//         ], 201);
//     } catch (\Exception $e) {
//         Log::error('Lỗi đặt dịch vụ: ' . $e->getMessage());
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Đã xảy ra lỗi khi đặt dịch vụ.',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

public function serviceBooking(Request $request)
{
    Log::info('Bắt đầu đặt dịch vụ với dữ liệu:', $request->all());
    try {
        // Kiểm tra người dùng đã xác thực chưa
        $user = Auth::user();
        Log::info('Người dùng:', ['user' => $user]);

        // Định nghĩa quy tắc xác thực
        $rules = [
            'pet_id' => 'required|integer|exists:pets,id',
            'service_id' => 'required|integer|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|in:10:00,12:00,14:00,16:00,18:00', // Các giờ hợp lệ
        ];

        if (!$user) {
            $rules['phone'] = 'required|string|max:15';
            $rules['email'] = 'required|email';
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xác thực thất bại',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kiểm tra sự trùng lặp của khung giờ đã chọn cho cùng một dịch vụ và ngày
        $existingBooking = ServiceBooking::where('service_id', $request->input('service_id'))
            ->where('booking_date', $request->input('booking_date'))
            ->where('booking_time', $request->input('booking_time'))
            ->first();

        if ($existingBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Khung giờ này đã được đặt. Vui lòng chọn khung giờ khác.',
            ], 409);
        }

        // Gán giá trị cho điện thoại và email
        $phone = $user ? $user->phone : $request->input('phone');
        $email = $user ? $user->email : $request->input('email');
        Log::info('Thông tin liên hệ:', ['phone' => $phone, 'email' => $email]);

        // Lấy giá dịch vụ từ bảng services
        $service = Service::findOrFail($request->input('service_id'));
        Log::info('Thông tin dịch vụ:', $service->toArray());
        $total_price = $service->price;

        // Tạo đặt dịch vụ mới
     // Tạo đặt dịch vụ mới
$booking = ServiceBooking::create([
    'user_id' => $request->input('user_id'),
    'pet_id' => $request->input('pet_id'),
    'service_id' => $request->input('service_id'),
    'booking_date' => $request->input('booking_date'),
    'booking_time' => $request->input('booking_time'), // Thêm trường này
    'phone' => $phone,
    'email' => $email,
    'status' => 'pending',
    'total_price' => $total_price,
]);

        Log::info('Dữ liệu đặt:', $booking->toArray());

        return response()->json([
            'status' => 'success',
            'alert' => 'Đặt dịch vụ thành công',
            'data' => $booking,
        ], 201);
    } catch (\Exception $e) {
        Log::error('Lỗi đặt dịch vụ: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Đã xảy ra lỗi khi đặt dịch vụ.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function bookingHistory(Request $request)
{
    try {
        // Lấy user_id từ request
        $userId = $request->input('user_id');

        // Kiểm tra nếu user_id không tồn tại
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thiếu user_id trong request.'
            ], 400);
        }

        // Lấy lịch sử đặt dịch vụ của user dựa trên user_id và thông tin từ các quan hệ liên quan
        $bookings = ServiceBooking::where('user_id', $userId)
            ->with([
                'pet:id,name', // Lấy id và tên của thú cưng
                'service:id,name' // Lấy id và tên của dịch vụ
            ])
            ->get(['id', 'booking_date', 'booking_time', 'total_price', 'status', 'pet_id', 'phone', 'email', 'service_id']);

        // Định dạng lại thời gian booking_time nếu cần
        $bookings->transform(function ($booking) {
            $booking->booking_time = Carbon::parse($booking->booking_time)->format('H:i'); // Định dạng lại giờ (HH:mm)
            return $booking;
        });

        // Trả về dữ liệu trực tiếp từ $bookings
        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ], 200);
    } catch (\Exception $e) {
        Log::error('Lỗi lấy lịch sử đặt dịch vụ: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Đã xảy ra lỗi khi lấy lịch sử đặt dịch vụ.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function cancelBooking(Request $request, $bookingId)
{
    $booking = ServiceBooking::find($bookingId);

    // Kiểm tra nếu booking không tồn tại hoặc ngày đặt đã qua
    if (!$booking || $booking->booking_date < now()->toDateString()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Bạn không thể hủy lịch đã qua ngày.'
        ], 400);
    }

    $booking->update(['status' => 'Cancelled']);

    return response()->json([
        'status' => 'success',
        'message' => 'Lịch đặt đã được hủy thành công.'
    ]);
}








}
