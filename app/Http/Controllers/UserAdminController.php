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

class UserAdminController extends Controller
{
  
public function users(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
    $page = $request->input('page', 1);

    // Tạo truy vấn cơ bản cho User
    $query = User::query();

    // Áp dụng tìm kiếm theo tên hoặc email nếu có từ khóa tìm kiếm
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")    ;
        });
    }

    // Lấy kết quả phân trang
    $users = $query->paginate($perPage, ['*'], 'page', $page);

    // Trả về kết quả
    return response()->json($users, 200);
}


public function updateUser(Request $request, $id)
{
    // Xác thực dữ liệu cho is_action
    $validatedData = $request->validate([
        'is_action' => 'required|boolean' // Xác thực giá trị phải là boolean
    ]);

    // Tìm người dùng theo ID
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404); // Trả về 404 nếu không tìm thấy người dùng
    }

    // Cập nhật giá trị của is_action
    $user->is_action = $validatedData['is_action'];

    // Lưu thay đổi
    $user->save();

    // Trả về phản hồi thành công kèm theo dữ liệu người dùng
    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user
    ], 200); // Trả về mã HTTP 200 cho yêu cầu thành công
}

public function getUserById($id)
{
    // Tìm sản phẩm theo ID
    $category = User::get()->find($id);
    
    // Kiểm tra xem sản phẩm có tồn tại không
    if (!$category) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    return response()->json($category, 200);
}
public function deleteUser($id)
{
    // Tìm người dùng theo ID
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Xóa người dùng
    $user->delete();

    // Trả về phản hồi thành công
    return response()->json(['message' => 'User deleted successfully'], 200);
}
public function updateUserStatusBasedOnCancelledOrders()
{
    // Lấy tất cả các user_id có từ 5 đơn hàng bị hủy trở lên, không giới hạn ngày
    $userIds = Order::select('user_id')
        ->where('status', 'cancle')
        ->groupBy('user_id')
        ->havingRaw('COUNT(*) >= 5')
        ->pluck('user_id');

    // Cập nhật trạng thái người dùng
    User::whereIn('id', $userIds)->update(['is_action' => 1]);

    return response()->json(['message' => 'User statuses updated based on cancelled orders']);
}


}