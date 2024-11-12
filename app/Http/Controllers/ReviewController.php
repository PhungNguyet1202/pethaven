<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

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
        $review = new Review();
        $review->user_id = $request->user_id;
        $review->product_id = $product->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;

        $review->save();

        return response()->json(['success' => true, 'message' => 'Đánh giá đã được thêm thành công']);
    }

}

