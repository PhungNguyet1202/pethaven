<?php

 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function dashboard()
    {
        $soDonHang = Order::count();
        $soSanPham = Product::count();
        $soKhachHang = User::where('role', 'user')->count();
        $doanhThu = Order::where('status', 'success')->sum('total_money');
        $dsDH = Order::orderBy('created_at', 'DESC')->limit(5)->get();
        $dsBL = Comment::orderBy('created_at', 'DESC')->limit(5)->get();
        
        return response()->json([
            'soDonHang' => $soDonHang,
            'soSanPham' => $soSanPham,
            'soKhachHang' => $soKhachHang,
            'doanhThu' => $doanhThu,
            'dsDH' => $dsDH,
            'dsBL' => $dsBL
        ], 200);
    }

    public function product(Request $request)
    {
        // Get search query and pagination parameters
        $search = $request->input('search');
        $perPage = $request->input('perPage', 9); // Default to 10 items per page
        $page = $request->input('page', 1);
    
        // Build the query
        $query = Product::with('category')
                        ->withSum('stockIns', 'Quantity');
    
        // Apply search filter
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%"); // Assuming product has 'code'
        }
        
        // Get paginated results
        $products = $query->paginate($perPage, ['*'], 'page', $page);
    
        return response()->json($products, 200);
    }

  
    public function postproductAdd(Request $request)
    {
        // Xác thực dữ liệu từ request
        $request->validate([
            'name' => 'required|string',
            'description1' => 'nullable|string',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'instock' => 'required|integer',
            'sale_price' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048' // Xác thực hình ảnh
        ]);
    
        // Tạo đối tượng sản phẩm mới
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description1;
        $product->categories_id = $request->category_id;
        $product->price = $request->price;
        $product->instock = $request->instock;
        $product->sale_price = $request->sale_price;
    
        // Lưu sản phẩm để có được ID
        $product->save();
    
        // Kiểm tra và lưu hình ảnh nếu có
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            
            // Sử dụng ID sản phẩm đã lưu để tạo tên hình ảnh
            $imgName = "{$product->id}." . $img->getClientOriginalExtension();
    
            // Di chuyển hình ảnh vào thư mục public/img1
            $img->move(public_path('img1/'), $imgName);
            
            // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
            $product->image = $imgName;
        }
    
        // Cập nhật hình ảnh nếu có
        $product->save();
    
        // Trả về phản hồi JSON
        return response()->json(['message' => 'Thêm sản phẩm thành công', 'product' => $product], 201);
    }
    
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'description1' => 'nullable|string',
            'category_id' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'instock' => 'sometimes|required|integer',
            'sale_price' => 'sometimes|nullable|numeric',
            'image' => 'sometimes|nullable|image|max:2048' // Add validation for the image
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->name = $request->name ?? $product->name;
        $product->slug = $request->name ? Str::slug($request->name) : $product->slug;
        $product->description = $request->description1 ?? $product->description;
        $product->categories_id = $request->category_id ?? $product->categories_id;
        $product->price = $request->price ?? $product->price;
        $product->instock = $request->instock ?? $product->instock;
        $product->sale_price = $request->sale_price ?? $product->sale_price;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }

            $img = $request->file('image');
            $imgName = "{$product->id}." . $img->getClientOriginalExtension();
            $img->move(public_path('images/products/'), $imgName);
            $product->image = $imgName;
        }

        $product->save();
        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
    public function getProductById($id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::with('category')->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($product, 200);
    }

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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
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
        'image' => 'nullable|image|max:2048' // Xác thực hình ảnh
    ]);

    // Tạo đối tượng danh mục mới
    $category = new Category();
    $category->name = $request->name;
    $category->slug = Str::slug($request->name);
    $category->description = $request->description;

    // Lưu danh mục để có được ID
    $category->save();

    // Kiểm tra và lưu hình ảnh nếu có
    if ($request->hasFile('image')) {
        $img = $request->file('image');
        // Sử dụng ID danh mục đã lưu để tạo tên hình ảnh
        $imgName = "{$category->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/categories/'), $imgName);
        $category->image = $imgName;
    }

    // Cập nhật hình ảnh nếu có
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
        'image' => 'sometimes|nullable|image|max:2048'
    ]);

    // Tìm danh mục theo ID
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Cập nhật thông tin
    $category->name = $request->name ?? $category->name;
    $category->slug = $request->name ? Str::slug($request->name) : $category->slug;
    $category->description = $request->description ?? $category->description;

    // Xử lý hình ảnh
    if ($request->hasFile('image')) {
        if ($category->image && file_exists(public_path('images/categories/' . $category->image))) {
            unlink(public_path('images/categories/' . $category->image));
        }

        $img = $request->file('image');
        $imgName = "{$category->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/categories/'), $imgName);
        $category->image = $imgName;
    }

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