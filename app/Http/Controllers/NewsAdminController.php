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


class NewsAdminController extends Controller
{


    public function categoryNew(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);
    
        // Tạo truy vấn cơ bản cho CategoryNew
        $query = CategoryNew::query();
    
        // Áp dụng tìm kiếm theo tên nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
    
        // Lấy kết quả phân trang
        $categoriesNew = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Trả về kết quả
        return response()->json($categoriesNew, 200);
    }
    public function getCategoryNewById($id)
    {
        // Tìm sản phẩm theo ID
        $category = CategoryNew::get()->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$category) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($category, 200);
    }
    public function postCategoryNewAdd(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
    
        // Tạo đối tượng mới
        $categoryNew = new CategoryNew();
        $categoryNew->name = $request->name;
        $categoryNew->description = $request->description;
    
        // Lưu danh mục mới
        $categoryNew->save();
    
        return response()->json(['message' => 'Thêm danh mục mới thành công'], 201);
    }
    public function updateCategoryNew(Request $request, $id)
    {
        // Log thông tin bắt đầu cập nhật
        Log::info("Starting updateCategoryNew for category ID: $id");
        
        // Log giá trị request nhận được
        Log::info('Request data: ', $request->all());
        Log::info('Request headers: ', $request->headers->all());
    
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
        ]);
    
        // Tìm danh mục theo ID
        $categoryNew = CategoryNew::find($id);
        if (!$categoryNew) {
            Log::warning("Category not found for ID: $id");
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }
    
        // Cập nhật thông tin
        $categoryNew->name = $request->name ?? $categoryNew->name;
        $categoryNew->description = $request->description ?? $categoryNew->description;
    
        // Lưu thay đổi
        $categoryNew->save();
        
        Log::info('Category updated successfully for ID: ' . $id);
    
        return response()->json(['message' => 'Cập nhật danh mục thành công'], 200);
    }
    
    public function deleteCategoryNew($id)
    {
        $categoryNew = CategoryNew::find($id);
        if (!$categoryNew) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }
    
        // Kiểm tra xem có bản ghi nào trong bảng news có sử dụng danh mục này không
        $newsExists = News::where('categorynew_id', $id)->exists();
    
        if ($newsExists) {
            return response()->json(['message' => 'Danh mục đang được sử dụng trong bảng tin tức, không thể xóa'], 400);
        }
    
        // Xóa danh mục
        $categoryNew->delete();
    
        return response()->json(['message' => 'Xóa danh mục thành công'], 200);
    }
    
    
    public function news(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);
    
        // Tạo truy vấn cho News với liên kết đến CategoryNew
        $query = News::with('categorynew');
    
        // Áp dụng tìm kiếm theo tiêu đề hoặc nội dung nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }
    
        // Lấy kết quả phân trang
        $newsItems = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Định dạng lại dữ liệu để bao gồm tên danh mục, image và description
        $formattedNews = $newsItems->getCollection()->map(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'categorynew_id' => $news->categorynew ? $news->categorynew->id : null,
                'category_name' => $news->categorynew ? $news->categorynew->name : null, // Lấy tên danh mục
                'created_at' => $news->created_at,
                'updated_at' => $news->updated_at,
                'image' => $news->image, // Thêm trường image
                'description1' => $news->description1, // Thêm trường description
                'description2' => $news->description2,
            ];
        });
    
        // Cập nhật lại tổng số trang cho response
        $newsItems->setCollection($formattedNews);
    
        return response()->json($newsItems, 200);
    }
    
    public function newCategory(Request $request)
    {
        $dsCT = CategoryNew::get();
        if ($dsCT->isEmpty()) {
            return response()->json(['message' => 'No categories found'], 404);
        }
        return response()->json($dsCT, 200);
    }
    
    
    public function getNewById($id)
    {
        // Tìm bài viết theo ID, đồng thời lấy thông tin danh mục
        $news = News::with('categorynew')->find($id);
        
        // Kiểm tra xem bài viết có tồn tại không
        if (!$news) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
    
        // Định dạng dữ liệu trả về
        $newsData = [
            'id' => $news->id,
            'title' => $news->title,
            'content' => $news->content,
            'image' => $news->image ,
            'description1'  => $news->description1,
            'description2'  => $news->description2,
            'categorynew_id' => $news->categorynew ? $news->categorynew->id : null,
            'category_name' => $news->categorynew ? $news->categorynew->name : null, // Lấy tên danh mục
        ];
    
        return response()->json($newsData, 200);
    }
    public function postNewsAdd(Request $request)
    {
        try {
            // Xác thực dữ liệu
            $validatedData = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'categorynew_id' => 'required|exists:categorynews,id', // Giả sử id là khóa chính
                'user_id' => 'required|exists:users,id', // Xác thực user_id
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Xác thực hình ảnh
                'description1' => 'nullable|string',
                'description2' => 'nullable|string|max:200',
            ]);
    
            // Tạo bài viết mới
            $news = new News();
            $news->title = $validatedData['title'];
            $news->content = $validatedData['content'];
            $news->categorynew_id = $validatedData['categorynew_id'];
            $news->user_id = $validatedData['user_id']; // Gán user_id cho bài viết
            $news->description1 = $validatedData['description1'];
            $news->description2 = $validatedData['description2'];
    
            // Đường dẫn lưu ảnh
            $destinationPath = public_path('images/news');
            $imgName = 'default-image.jpg'; // Giá trị mặc định
    
            // Kiểm tra và lưu hình ảnh nếu có
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imgName = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $imgName);
                $news->image = $imgName; // Lưu tên hình ảnh vào bài viết
            }
    
            // Lưu bài viết vào database
            $news->save();
    
            return response()->json(['status' => 'success', 'message' => 'Thêm bài viết thành công.'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Thêm bài viết thất bại.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
    
    
    public function updateNews(Request $request, $id)
    {
        // Ghi log dữ liệu nhận từ front-end
        Log::info('Data received from front-end for update:', $request->all());
    
        // Xác thực dữ liệu
        try {
            $request->validate([
                'title' => 'sometimes|required|string',
                'content' => 'sometimes|required|string',
                'categorynew_id' => 'exists:categorynews,id',
                'user_id' => 'sometimes|required|exists:users,id',
               
                'description1' => 'sometimes|nullable|string',
                'description2' => 'sometimes|nullable|string|max:200',
            ]);
            Log::info('Validation passed.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ', $e->errors());
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }
    
        // Tìm bài viết
        $news = News::find($id);
        if (!$news) {
            Log::error("News with ID {$id} not found.");
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
        
        Log::info('Original News data:', $news->toArray());
    
        // Cập nhật thông tin bài viết
        $news->title = $request->title ?? $news->title;
        $news->content = $request->content ?? $news->content;
            $news->categorynew_id = $request->categorynew_id ?? $news->categorynew_id;
        
        if (isset($request->user_id)) {
            $news->user_id = $request->user_id;
            Log::info('User ID updated to: ' . $news->user_id);
        }
    
        $news->description1 = $request->description1 ?? $news->description1;
        $news->description2 = $request->description2 ?? $news->description2;
    
        Log::info('Updated News data (before save):', $news->toArray());
    
        // Xử lý hình ảnh mới nếu có
        if ($request->hasFile('image')) {
            $destinationPath = public_path('images/news');
            $imgName = 'default-image.jpg'; // Giá trị mặc định
    
            
            // Kiểm tra và xóa ảnh cũ nếu có
            if ($news->image && file_exists($destinationPath . '/' . $news->image)) {
                Log::info("Deleting old image: " . $destinationPath . '/' . $news->image);
                if (!unlink($destinationPath . '/' . $news->image)) {
                    Log::error("Failed to delete old image for news ID {$news->id}");
                } else {
                    Log::info("Old image deleted successfully.");
                }
            }
    
            // Upload ảnh mới
            $img = $request->file('image');
            $imgName = "{$news->id}." . $img->getClientOriginalExtension();
            if ($img->move($destinationPath, $imgName)) {
                Log::info("New image uploaded: " . $destinationPath . '/' . $imgName);
                $news->image = $imgName;
            } else {
                Log::error("Failed to upload new image for news ID {$news->id}");
            }
        }
    
        // Kiểm tra sự thay đổi trước khi lưu
        if ($news->isDirty()) {
            Log::info('Data has changed, saving...');
            try {
                $news->save();
                Log::info("News ID {$news->id} updated successfully.");
            } catch (\Exception $e) {
                Log::error("Failed to save news: " . $e->getMessage());
                return response()->json(['message' => 'Lỗi khi lưu dữ liệu'], 500);
            }
        } else {
            Log::info('No changes detected, not saving.');
        }
    
        // Trả về phản hồi với dữ liệu cập nhật
        return response()->json([
            'message' => 'Cập nhật bài viết thành công',
            'updated_news' => $news->fresh() // Lấy dữ liệu mới nhất từ cơ sở dữ liệu
        ], 200);
    }
    
    
    public function deleteNews($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
    
        // Xóa hình ảnh nếu có
        if ($news->image && file_exists(public_path('images/news/' . $news->image))) {
            unlink(public_path('images/news/' . $news->image));
        }
    
        // Xóa bài viết
        $news->delete();
    
        return response()->json(['message' => 'Xóa bài viết thành công'], 200);
    }
    
    
}