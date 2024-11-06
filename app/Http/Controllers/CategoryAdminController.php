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


class CategoryAdminController extends Controller
{
    public function category(Request $request)
    {
        // Get search query and pagination parameters
        $search = $request->input('search');
        $perPage = $request->input('perPage', 9); // Default to 10 items per page
        $page = $request->input('page', 1);
    
        // Build the query
        $query = Category::query();
    
        // Apply search filter with grouped conditions
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
    
        // Get paginated results
        $categories = $query->paginate($perPage, ['*'], 'page', $page);
    
        return response()->json($categories, 200);
    }
    public function getCategoryById($id)
    {
        // Tìm sản phẩm theo ID
        $category = Category::get()->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$category) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($category, 200);
    }


public function postCategoryAdd(Request $request)
{
    // Xác thực dữ liệu từ request
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
    
    ]);

    // Tạo đối tượng danh mục mới
    $category = new Category();
    $category->name = $request->name;
    $category->description = $request->description;

    // Lưu danh mục để có được ID
    $category->save();



    // Trả về phản hồi
    return response()->json(['message' => 'Thêm danh mục thành công'], 201);
}

public function updateCategory(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'sometimes|required|string',
        'description' => 'nullable|string',
     
    ]);

    // Tìm danh mục theo ID
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Cập nhật thông tin
    $category->name = $request->name ?? $category->name;

    $category->description = $request->description ?? $category->description;

    // Xử lý hình ảnh
   

    $category->save();

    return response()->json(['message' => 'Category updated successfully'], 200);
}

public function deleteCategory($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Xóa hình ảnh nếu có
    if ($category->image && file_exists(public_path('images/categories/' . $category->image))) {
        unlink(public_path('images/categories/' . $category->image));
    }

    $category->delete();

    return response()->json(['message' => 'Category deleted successfully'], 200);
}
}