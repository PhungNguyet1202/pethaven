<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    // Lấy tất cả đánh giá của một sản phẩm
    public function index(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
                ->with('user:id,name') // Gọi quan hệ user và lấy id, name của người dùng
                ->get();

    return response()->json($reviews);
    }

    // Thêm đánh giá cho sản phẩm (chỉ dành cho người đã đăng nhập)
    public function store(Request $request, Product $product)
    {
        // Kiểm tra nếu `user_id` không được cung cấp
        if (!$request->has('user_id')) {
            return response()->json(['success' => false, 'message' => 'Thiếu user_id'], 400);
        }

        // Validate dữ liệu
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        // Tạo mới đánh giá
      // Tạo mới đánh giá
$review = new Review();
$review->user_id = $request->user_id;
$review->product_id = $product->id;
$review->rating = $request->rating;
$review->comment = $request->comment;
$review->save();

// Gọi phương thức cập nhật rating của sản phẩm
$this->updateProductRating($product->id);

return response()->json(['success' => true, 'message' => 'Đánh giá đã được thêm thành công']);

    }
    public function getRatingSummary(Product $product)
{
    // Tính tổng số bình luận
    $totalReviews = Review::where('product_id', $product->id)->count();

    // Tính rating trung bình
    $averageRating = Review::where('product_id', $product->id)->avg('rating');

    // Đảm bảo trả về rating trung bình với tối đa 1 chữ số thập phân
    $averageRating = round($averageRating, 1);

    return response()->json([
        'average_rating' => $averageRating,
        'total_reviews' => $totalReviews,
    ]);
}



public function updateProductRating($productId)
{
    // Tính trung bình rating từ bảng reviews
    $averageRating = DB::table('reviews')
        ->where('product_id', $productId)
        ->avg('rating');

    // Cập nhật cột rating trong bảng products
    Product::where('id', $productId)->update(['rating' => round($averageRating, 1)]);
}

}

