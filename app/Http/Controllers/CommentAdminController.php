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
use App\Models\Review;
use App\Models\Service;
use App\Models\inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentAdminController extends Controller
{
    public function comment(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
    
        // Tạo truy vấn cơ bản cho Comment cùng với User và Product
        $query = Review::with(['user', 'product']);
    
        // Áp dụng tìm kiếm theo nội dung bình luận hoặc tên người dùng nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
            });
        }
    
        // Phân trang kết quả
        $comments = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Sử dụng map để định dạng lại dữ liệu
        $formattedComments = $comments->getCollection()->map(function ($comment) {
            return [
                'id' => $comment->id,
                 'rating'=>$comment->Rating,
                'content' => $comment->Comment,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user ? $comment->user->name : null, // Lấy tên người dùng
                'product_id' => $comment->product_id,
                'product_name' => $comment->product ? $comment->product->name : null, // Lấy tên sản phẩm
            ];
        });
    
        // Cập nhật lại tổng số trang cho response
        $comments->setCollection($formattedComments);
    
        return response()->json($comments);
    }
    
    
    
    public function deleteComment($id)
    {
        $comment = Review::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Bình luận không tồn tại'], 404);
        }
    
        // Xóa bình luận
        $comment->delete();
    
        return response()->json(['message' => 'Xóa bình luận thành công'], 200);
    }
    
}