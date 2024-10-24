<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hàm hiển thị danh sách sản phẩm với tính năng tìm kiếm và phân trang
    public function product(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ yêu cầu của người dùng
        $search = $request->input('search'); // Từ khóa tìm kiếm
        $perPage = $request->input('perPage', 9); // Mặc định hiển thị 9 sản phẩm mỗi trang
        $page = $request->input('page', 1); // Số trang hiện tại, mặc định là trang 1

        // Xây dựng truy vấn sản phẩm, bao gồm thông tin danh mục và tính tổng số lượng tồn kho
        $query = Product::with('category')
                        ->withSum('stockIns', 'Quantity'); // Lấy tổng số lượng nhập kho

        // Áp dụng bộ lọc tìm kiếm nếu người dùng có nhập từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%") // Tìm theo tên sản phẩm
                  ->orWhere('code', 'like', "%{$search}%"); // Tìm theo mã sản phẩm
            });
        }

        // Thực hiện truy vấn và phân trang kết quả
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // Trả kết quả về dưới dạng JSON với mã HTTP 200
        return response()->json($products, 200);
    }

    // Hàm hiển thị chi tiết sản phẩm theo slug
    public function detail($slug)
    {
        // Tìm sản phẩm theo slug (đường dẫn thân thiện)
        $product = Product::where('slug', $slug)->first();

        // Kiểm tra sản phẩm có tồn tại không
        if ($product) {
            return response()->json([
                'status' => 'success',
                'product' => $product
            ], 200); // Trả về JSON sản phẩm với mã 200 (OK)
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404); // Trả về lỗi nếu không tìm thấy sản phẩm với mã 404
        }
    }

    // Hàm hiển thị sản phẩm theo danh mục
    public function productsByCategory($categorySlug)
    {
        // Tìm danh mục theo slug
        $category = Category::where('slug', $categorySlug)->first();

        // Kiểm tra nếu danh mục tồn tại
        if ($category) {
            // Lấy danh sách sản phẩm thuộc danh mục đó và phân trang (6 sản phẩm mỗi trang)
            $products = Product::where('category_id', $category->id)->paginate(6);
            return view('product.product', compact('products', 'category'));
        } else {
            // Chuyển hướng nếu không tìm thấy danh mục và thông báo lỗi
            return redirect()->route('home')->with('error', 'Category not found');
        }
    }

    // Hàm hiển thị chi tiết sản phẩm theo ID (nếu sử dụng)
    public function detailById($id)
    {
        // Tìm sản phẩm theo ID và ném lỗi nếu không tìm thấy
        $product = Product::findOrFail($id);

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($product);
    }
}
