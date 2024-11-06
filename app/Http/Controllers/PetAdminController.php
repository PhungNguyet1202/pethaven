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

class PetAdminController extends Controller
{
 
public function pet(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
    $page = $request->input('page', 1);

    // Tạo truy vấn cơ bản cho Pet
    $query = Pet::query();

    // Áp dụng tìm kiếm theo tên hoặc mô tả nếu có từ khóa tìm kiếm
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
               ;
        });
    }

    // Lấy kết quả phân trang
    $pets = $query->paginate($perPage, ['*'], 'page', $page);

    // Trả về kết quả
    return response()->json($pets, 200);
}
public function getPetById($id)
    {
        // Tìm sản phẩm theo ID
        $category = pet::get()->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$category) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($category, 200);
    }
    
    public function postPetAdd(Request $request)
    {
        $pet = new Pet();
        $pet->name = $request->input('name');
        $pet->user_id = $request->input('userId'); // Lấy userId từ request
        $pet->save();
    
        return response()->json(['message' => 'Pet added successfully'], 200);
    }
    public function updatePet(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'sometimes|required|string',
            'userId' => 'required|integer', // Thêm xác thực cho userId
        ]);
    
        // Tìm pet theo ID
        $pet = Pet::find($id);
        if (!$pet) {
            return response()->json(['message' => 'Pet không tồn tại'], 404);
        }
    
        // Cập nhật thông tin
        $pet->name = $request->name ?? $pet->name;
        $pet->user_id = $request->input('userId'); // Cập nhật userId từ request
    
        // Lưu thay đổi
        $pet->save();
    
        return response()->json(['message' => 'Cập nhật pet thành công'], 200);
    }
public function deletePet($id)
{
    $pet = Pet::find($id);
    if (!$pet) {
        return response()->json(['message' => 'Pet không tồn tại'], 404);
    }

 

    // Xóa pet
    $pet->delete();

    return response()->json(['message' => 'Xóa pet thành công'], 200);
}

}