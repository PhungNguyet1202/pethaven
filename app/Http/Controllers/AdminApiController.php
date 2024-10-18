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
use App\Models\service;
use Illuminate\Support\Str;

class AdminApiController extends Controller
{
    public function dashboard(){
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

    public function product() {
        $dsSP = Product::with('category')  // Lấy thông tin danh mục
                       ->withSum('stockIns', 'Quantity') // Sử dụng đúng tên phương thức
                       ->paginate(10);

        return response()->json($dsSP, 200);
    }

    public function category() {
        $dsCT = Category::paginate(10);
        return response()->json($dsCT, 200);
    }

    public function user() {
        $dsUS = User::paginate(10);
        return response()->json($dsUS, 200);
    }

    public function categoryNew() {
        $dsCTN = CategoryNew::paginate(10);
        return response()->json($dsCTN, 200);
    }

    public function news() {
        $dsNew = News::with('categoryNew')->paginate(10);
        return response()->json($dsNew, 200);
    }

    public function pet() {
        $dsPet = Pet::paginate(10);
        return response()->json($dsPet, 200);
    }
    public function comment() {
        $dsCM = Comment::paginate(10);
        return response()->json($dsCM, 200);
    }
    public function service() {
        $dsPet = service::paginate(10);
        return response()->json($dsPet, 200);
    }



    public function productAdd(Request $request) {
        $dsCT = Category::get();
        return response()->json($dsCT, 200);
    }
// productADD
    public function postproductAdd(Request $request) {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description1;
        $product->categories_id = $request->category_id;
        $product->price = $request->price;
        $product->instock = $request->instock;
        $product->sale_price = $request->sale_price;
        $product->image = '';
        $product->save();

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = trim("{$product->id}.{$img->getClientOriginalExtension()}");
            $img->move(public_path('images/products/'), $imgName);
            $product->image = $imgName;
            $product->save();
        }

        return response()->json(['message' => 'Product added successfully'], 201);
    }
    public function updateProduct(Request $request, $id) {
        // Tìm sản phẩm theo id
        $product = Product::find($id);
        
        // Kiểm tra nếu sản phẩm không tồn tại
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Cập nhật thông tin sản phẩm
        $product->name = $request->name ?? $product->name;
        $product->slug = $request->name ? Str::slug($request->name) : $product->slug;
        $product->description = $request->description1 ?? $product->description;
        $product->categories_id = $request->category_id ?? $product->categories_id;
        $product->price = $request->price ?? $product->price;
        $product->instock = $request->instock ?? $product->instock;
        $product->sale_price = $request->sale_price ?? $product->sale_price;
    
        // Kiểm tra nếu có file ảnh mới được upload
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
    
            // Lưu ảnh mới
            $img = $request->file('image');
            $imgName = trim("{$product->id}.{$img->getClientOriginalExtension()}");
            $img->move(public_path('images/products/'), $imgName);
            $product->image = $imgName;
        }
    
        // Lưu thay đổi vào cơ sở dữ liệu
        $product->save();
    
        return response()->json(['message' => 'Product updated successfully'], 200);
    }
    public function deleteProduct($id) {
        // Tìm sản phẩm theo id
        $product = Product::find($id);
        
        // Kiểm tra nếu sản phẩm không tồn tại
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Xóa ảnh nếu có
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
    
        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
    
    
}