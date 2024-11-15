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


class ProductAdminController extends Controller
{
    
public function productCategory(Request $request)
{
    $dsCT = Category::get();
    if ($dsCT->isEmpty()) {
        return response()->json(['message' => 'No categories found'], 404);
    }
    return response()->json($dsCT, 200);
}

public function product(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 9); // Mặc định là 9 sản phẩm trên mỗi trang
        $page = $request->input('page', 1);
    
        // Tạo truy vấn với các mối quan hệ
        $query = Product::with('category')->withSum('stockIns', 'Quantity');
    
        // Áp dụng tìm kiếm nếu có
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%"); // Giả định sản phẩm có 'code'
            });
        }
    
        // Lấy kết quả phân trang
        $products = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Định dạng lại dữ liệu để bao gồm tên danh mục
        $formattedProducts = $products->getCollection()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'code' => $product->code,
                'category_id' => $product->category_id,
                'category_name' => $product->category ? $product->category->name : null, // Lấy tên danh mục
                'stock_quantity' => $product->instock ?? 0,
                // 'stock_quantity' => $product->stock_ins_sum_quantity ?? 0,  // Số lượng tồn kho
            ];
        });
    
        // Cập nhật lại tổng số trang cho response
        $products->setCollection($formattedProducts);
    
        return response()->json($products, 200);
    }
    
    public function getProductById($id)
{
    $product = Product::with('category')->find($id);
    
    if (!$product) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

  

    $productData = [
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'sale_price' => $product->sale_price,
        'image' =>$product->image, // URL đầy đủ cho hình ảnh
        'category_name' => $product->category ? $product->category->name : null,
        'instock' => $product->instock,
        'category_id' => $product->category ? $product->category->id : null,
        'description' => $product->description,
    ];

    return response()->json($productData, 200);
}

    public function postproductAdd(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
              
            ]);
    
            // Đường dẫn lưu ảnh
            $destinationPath = public_path('images/products');

            $imageName = 'default-image.jpg'; // Giá trị mặc định
    
            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $imageName);
            }
    
            // Lưu thông tin sản phẩm vào database
            $product = new Product([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'categories_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                 'instock'=>0,
                'sale_price' => $request->input('sale_price'),
                'image' => $imageName,
            ]);
            $product->save();
    
            return response()->json(['status' => 'success', 'message' => 'Product added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to add product.', 'error' => $e->getMessage()], 500);
        }
    }
    public function updateProduct(Request $request, $id)
    {
        // Log bắt đầu của hàm
        Log::info("Starting updateProduct for product ID: $id");
    
        // Ghi log tất cả dữ liệu yêu cầu
        Log::info('Request data: ', $request->all());
    
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'name' => 'required',
         
            'price' => 'required|numeric',
          
        ]);
    
        // Tìm sản phẩm theo ID
        $product = Product::find($id);
        if (!$product) {
            Log::warning("Product not found for ID: $id");
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Cập nhật dữ liệu nếu có
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->categories_id = $request->input('category_id', $product->categories_id);
        $product->price = $request->price;
        $product->sale_price = $request->sale_price ?? $product->sale_price;
    
        // Log dữ liệu cập nhật
        Log::info('Updated product data before saving: ', $product->toArray());
    
        try {
            // Xử lý ảnh nếu có ảnh mới
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = "{$product->id}." . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/products');
    
                // Xóa ảnh cũ nếu có
                if ($product->image && file_exists("$destinationPath/{$product->image}")) {
                    unlink("$destinationPath/{$product->image}");
                }
    
                // Lưu ảnh mới
                $image->move($destinationPath, $imageName);
                $product->image = $imageName;
    
                Log::info("Updated product image: $imageName");
            }
    
            // Lưu thay đổi vào database
            $product->save();
            Log::info("Product updated successfully for ID: $id");
    
            return response()->json(['message' => 'Product updated successfully'], 200);
    
        } catch (\Exception $e) {
            Log::error('Failed to update product. Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update product', 'error' => $e->getMessage()], 500);
        }
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
    //
}