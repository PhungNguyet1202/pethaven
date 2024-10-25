<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class AdminApiController extends Controller
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

//user

public function users(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
    $page = $request->input('page', 1);

    // Tạo truy vấn cơ bản cho User
    $query = User::query();

    // Áp dụng tìm kiếm theo tên hoặc email nếu có từ khóa tìm kiếm
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Lấy kết quả phân trang
    $users = $query->paginate($perPage, ['*'], 'page', $page);

    // Trả về kết quả
    return response()->json($users, 200);
}


public function updateUser(Request $request, $id)
{
    // Xác thực dữ liệu cho is_action
    $validatedData = $request->validate([
        'is_action' => 'required|boolean' // Xác thực giá trị phải là boolean
    ]);

    // Tìm người dùng theo ID
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404); // Trả về 404 nếu không tìm thấy người dùng
    }

    // Cập nhật giá trị của is_action
    $user->is_action = $validatedData['is_action'];

    // Lưu thay đổi
    $user->save();

    // Trả về phản hồi thành công kèm theo dữ liệu người dùng
    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user
    ], 200); // Trả về mã HTTP 200 cho yêu cầu thành công
}

public function getUserById($id)
{
    // Tìm sản phẩm theo ID
    $category = User::get()->find($id);
    
    // Kiểm tra xem sản phẩm có tồn tại không
    if (!$category) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    return response()->json($category, 200);
}
public function deleteUser($id)
{
    // Tìm người dùng theo ID
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Xóa người dùng
    $user->delete();

    // Trả về phản hồi thành công
    return response()->json(['message' => 'User deleted successfully'], 200);
}


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
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'sometimes|required|string',
        'description' => 'nullable|string',
    ]);

    // Tìm danh mục theo ID
    $categoryNew = CategoryNew::find($id);
    if (!$categoryNew) {
        return response()->json(['message' => 'Danh mục không tồn tại'], 404);
    }

    // Cập nhật thông tin
    $categoryNew->name = $request->name ?? $categoryNew->name;
    $categoryNew->description = $request->description ?? $categoryNew->description;

    // Lưu thay đổi
    $categoryNew->save();

    return response()->json(['message' => 'Cập nhật danh mục thành công'], 200);
}
public function deleteCategoryNew($id)
{
    $categoryNew = CategoryNew::find($id);
    if (!$categoryNew) {
        return response()->json(['message' => 'Danh mục không tồn tại'], 404);
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

    // Tạo truy vấn cơ bản cho News, liên kết với CategoryNew
    $query = news::with('categorynew');

    // Áp dụng tìm kiếm theo tiêu đề hoặc nội dung nếu có từ khóa tìm kiếm
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    // Lấy kết quả phân trang
    $news = $query->paginate($perPage, ['*'], 'page', $page);

    // Trả về kết quả
    return response()->json($news, 200);
}
public function getNewById($id)
{
    // Tìm sản phẩm theo ID
    $category = News::get()->find($id);
    
    // Kiểm tra xem sản phẩm có tồn tại không
    if (!$category) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    return response()->json($category, 200);
}
public function postNewsAdd(Request $request)
{
    // Xác thực dữ liệu
    $request->validate([
        'title' => 'required|string',
        'content' => 'required|string',
        'category_new_id' => 'required|exists:category_news,id',
        'image' => 'nullable|image|max:2048', // Xác thực hình ảnh
    ]);

    // Tạo bài viết mới
    $news = new News();
    $news->title = $request->title;
    $news->content = $request->content;
    $news->category_new_id = $request->category_new_id;

    // Lưu bài viết
    $news->save();

    // Kiểm tra và lưu hình ảnh nếu có
    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $imgName = "{$news->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/news/'), $imgName);
        $news->image = $imgName;
        $news->save();
    }

    return response()->json(['message' => 'Thêm bài viết thành công'], 201);
}
public function updateNews(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'title' => 'sometimes|required|string',
        'content' => 'sometimes|required|string',
        'category_new_id' => 'sometimes|required|exists:category_news,id',
        'image' => 'sometimes|nullable|image|max:2048', // Hình ảnh mới
    ]);

    // Tìm bài viết
    $news = News::find($id);
    if (!$news) {
        return response()->json(['message' => 'Bài viết không tồn tại'], 404);
    }

    // Cập nhật thông tin bài viết
    $news->title = $request->title ?? $news->title;
    $news->content = $request->content ?? $news->content;
    $news->category_new_id = $request->category_new_id ?? $news->category_new_id;

    // Xử lý hình ảnh mới nếu có
    if ($request->hasFile('image')) {
        if ($news->image && file_exists(public_path('images/news/' . $news->image))) {
            unlink(public_path('images/news/' . $news->image));
        }

        $img = $request->file('image');
        $imgName = "{$news->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/news/'), $imgName);
        $news->image = $imgName;
    }

    // Lưu thay đổi
    $news->save();

    return response()->json(['message' => 'Cập nhật bài viết thành công'], 200);
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
              ->orWhere('description', 'like', "%{$search}%");
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
        $category = Category::get()->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$category) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($category, 200);
    }
public function postPetAdd(Request $request)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
      
    ]);

    // Tạo pet mới
    $pet = new Pet();
    $pet->name = $request->name;
    $pet->description = $request->description;

    // Lưu pet
    $pet->save();


    return response()->json(['message' => 'Thêm pet thành công'], 201);
}
public function updatePet(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'sometimes|required|string',
        'description' => 'nullable|string',
        
    ]);

    // Tìm pet theo ID
    $pet = Pet::find($id);
    if (!$pet) {
        return response()->json(['message' => 'Pet không tồn tại'], 404);
    }

    // Cập nhật thông tin
    $pet->name = $request->name ?? $pet->name;
    $pet->description = $request->description ?? $pet->description;



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

//comment
public function comment(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10);
    $page = $request->input('page', 1);

    // Tạo truy vấn cơ bản cho Comment cùng với User và Product
    $query = Comment::with(['user', 'product']);

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
            'content' => $comment->content,
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
    $comment = Comment::find($id);
    if (!$comment) {
        return response()->json(['message' => 'Bình luận không tồn tại'], 404);
    }

    // Xóa bình luận
    $comment->delete();

    return response()->json(['message' => 'Xóa bình luận thành công'], 200);
}


//service
public function service(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
    $page = $request->input('page', 1);

    // Tạo truy vấn cơ bản cho Service
    $query = Service::query();

    // Áp dụng tìm kiếm theo tên dịch vụ hoặc mô tả nếu có từ khóa tìm kiếm
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Lấy kết quả phân trang
    $services = $query->paginate($perPage, ['*'], 'page', $page);

    // Trả về kết quả
    return response()->json($services, 200);
}
public function getServiceById($id)
    {
        // Tìm sản phẩm theo ID
        $category = Category::get()->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$category) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        return response()->json($category, 200);
    }
public function postServiceAdd(Request $request)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric', // Giá dịch vụ
        'image' => 'nullable|image|max:2048', // Xác thực hình ảnh nếu có
    ]);

    // Tạo service mới
    $service = new Service();
    $service->name = $request->name;
    $service->description = $request->description;
    $service->price = $request->price;

    // Lưu service
    $service->save();

    // Kiểm tra và lưu hình ảnh nếu có
    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $imgName = "{$service->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/services/'), $imgName);
        $service->image = $imgName;
        $service->save();
    }

    return response()->json(['message' => 'Thêm dịch vụ thành công'], 201);
}

public function updateService(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'sometimes|required|string',
        'description' => 'nullable|string',
        'price' => 'sometimes|required|numeric',
        'image' => 'sometimes|nullable|image|max:2048', // Hình ảnh mới
    ]);

    // Tìm service theo ID
    $service = Service::find($id);
    if (!$service) {
        return response()->json(['message' => 'Dịch vụ không tồn tại'], 404);
    }

    // Cập nhật thông tin
    $service->name = $request->name ?? $service->name;
    $service->description = $request->description ?? $service->description;
    $service->price = $request->price ?? $service->price;

    // Xử lý hình ảnh nếu có
    if ($request->hasFile('image')) {
        if ($service->image && file_exists(public_path('images/services/' . $service->image))) {
            unlink(public_path('images/services/' . $service->image));
        }

        $img = $request->file('image');
        $imgName = "{$service->id}." . $img->getClientOriginalExtension();
        $img->move(public_path('images/services/'), $imgName);
        $service->image = $imgName;
    }

    // Lưu thay đổi
    $service->save();

    return response()->json(['message' => 'Cập nhật dịch vụ thành công'], 200);
}
public function deleteService($id)
{
    $service = Service::find($id);
    if (!$service) {
        return response()->json(['message' => 'Dịch vụ không tồn tại'], 404);
    }

    // Xóa hình ảnh nếu có
    if ($service->image && file_exists(public_path('images/services/' . $service->image))) {
        unlink(public_path('images/services/' . $service->image));
    }

    // Xóa dịch vụ
    $service->delete();

    return response()->json(['message' => 'Xóa dịch vụ thành công'], 200);
}



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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%"); // Giả định sản phẩm có 'code'
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
                'stock_quantity' => $product->stock_ins_sum_quantity ?? 0, // Số lượng tồn kho
            ];
        });
    
        // Cập nhật lại tổng số trang cho response
        $products->setCollection($formattedProducts);
    
        return response()->json($products, 200);
    }
    
    public function getProductById($id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::with('category')->find($id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }
    
        // Định dạng lại sản phẩm để bao gồm category_name
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'image' => $product->image,
            'category_name' => $product->category ? $product->category->name : null, // Lấy tên danh mục
            'instock' => $product->instock,
            // Thêm các thuộc tính khác nếu cần
        ];
    
        return response()->json($productData, 200);
    }
public function postproductAdd(Request $request)
{
    try {
        // Validate dữ liệu, bao gồm file image
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý upload ảnh
        $imageName = 'default-image.jpg'; // Giá trị mặc định
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img1'), $imageName);
        }

        // Lưu thông tin sản phẩm vào database
        $product = new Product([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'categories_id' => $request->input('category_id'),
            'price' => $request->input('price'),
            'instock' => $request->input('instock'),
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
    // Xác thực dữ liệu từ request
    $request->validate([
        'name' => 'sometimes|required|string',
        'description1' => 'nullable|string',
        'category_id' => 'sometimes|required|integer',
        'price' => 'sometimes|required|numeric',
        'instock' => 'sometimes|required|integer',
        'sale_price' => 'sometimes|nullable|numeric',
        'image' => 'sometimes|nullable|image|max:2048' // Xác thực hình ảnh
    ]);

    // Tìm sản phẩm theo ID
    $product = Product::find($id);
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

    // Xử lý hình ảnh nếu có upload hình mới
    if ($request->hasFile('image')) {
        // Kiểm tra và xóa ảnh cũ nếu có
        if ($product->image && file_exists(public_path('img1/' . $product->image))) {
            unlink(public_path('img1/' . $product->image)); // Xóa ảnh cũ
        }

        // Upload ảnh mới
        $img = $request->file('image');
        $imgName = "{$product->id}." . $img->getClientOriginalExtension();
        
        // Đường dẫn lưu ảnh
        $destinationPath = 'D:\Dự án tốt nghiệp\UI\DUANTOTNGHIEP\pethaven\public\img1';
        
        // Di chuyển file ảnh đến đường dẫn đã chỉ định
        $img->move($destinationPath, $imgName);

            // Gán tên file ảnh mới vào cơ sở dữ liệu
            $product->image = $imgName;
        }

        // Lưu lại sản phẩm sau khi cập nhật thông tin và ảnh
        $product->save();

        // Trả về phản hồi
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
  // Lấy danh sách đơn hàng với phân trang và tìm kiếm
  public function orders(Request $request)
  {
      // Lấy thông tin tìm kiếm và phân trang từ request
      $search = $request->input('search');
      $perPage = $request->input('perPage', 10); // Mặc định 10 đơn hàng trên mỗi trang
      $page = $request->input('page', 1);
  
      // Tạo truy vấn với các mối quan hệ
      $query = Order::with(['user', 'payment', 'shipping']); // Đảm bảo rằng các mối quan hệ được định nghĩa đúng
  
      // Áp dụng tìm kiếm nếu có
      if ($search) {
          $query->where(function ($q) use ($search) {
              $q->where('user_fullname', 'like', "%{$search}%")
                ->orWhere('user_email', 'like', "%{$search}%")
                ->orWhere('user_phone', 'like', "%{$search}%");
          });
      }
  
      // Lấy kết quả phân trang
      $orders = $query->paginate($perPage, ['*'], 'page', $page);
  
      // Định dạng lại dữ liệu để bao gồm chi tiết người dùng, phương thức thanh toán, và vận chuyển
      $formattedOrders = $orders->getCollection()->map(function ($order) {
          return [
              'id' => $order->id,
              'user_fullname' => $order->user->fullname ?? null, // Thay 'fullname' theo cột thực tế
              'user_email' => $order->user->email ?? null, // Thay 'email' theo cột thực tế
              'user_phone' => $order->user->phone ?? null, // Thay 'phone' theo cột thực tế
              'total_money' => $order->total_money,
              'total_quantity' => $order->total_quantity,
              'status' => $order->status,
              'payment_method' => $order->payment ? $order->payment->method_name : null, // Thay 'method_name' theo cột thực tế
              'shipping_method' => $order->shipping ? $order->shipping->method_name : null, // Thay 'method_name' theo cột thực tế
              'created_at' => $order->created_at,
          ];
      });
  
      // Cập nhật lại tổng số trang cho response
      $orders->setCollection($formattedOrders);
  
      return response()->json($orders, 200);
  }
  

  // Lấy chi tiết đơn hàng dựa trên order_id
  public function orderDetail($order_id)
  {
      // Tìm đơn hàng theo id
      $order = Order::with('orderDetails.product', 'payment', 'shipping')->find($order_id);

      // Nếu không tìm thấy đơn hàng
      if (!$order) {
          return response()->json(['message' => 'Order not found'], 404);
      }

      // Định dạng lại chi tiết đơn hàng
      $formattedOrder = [
          'id' => $order->id,
          'user_fullname' => $order->user_fullname,
          'user_email' => $order->user_email,
          'user_phone' => $order->user_phone,
          'total_money' => $order->total_money,
          'total_quantity' => $order->total_quantity,
          'status' => $order->status,
          'payment_method' => $order->payment ? $order->payment->payment_method : null,
          'shipping_method' => $order->shipping ? $order->shipping->shipping_method : null,
          'order_details' => $order->orderDetails->map(function ($detail) {
              return [
                  'product_id' => $detail->product_id,
                  'product_name' => $detail->product->name,
                  'quantity' => $detail->quantity,
                  'price' => $detail->price,
                  'total_price' => $detail->price * $detail->quantity,
              ];
          }),
          'created_at' => $order->created_at,
      ];

      return response()->json($formattedOrder, 200);
  }
  public function serviceBooking(Request $request)
  {
      // Lấy thông tin tìm kiếm và phân trang từ request
      $search = $request->input('search');
      $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
      $page = $request->input('page', 1);

      // Tạo truy vấn cơ bản cho ServiceBooking cùng với user, pet, và service
      $query = ServiceBooking::with(['user', 'pet', 'service']);

      // Áp dụng tìm kiếm nếu có từ khóa tìm kiếm
      if ($search) {
          $query->where(function ($q) use ($search) {
              $q->where('booking_date', 'like', "%{$search}%") // Tìm theo ngày đặt
                ->orWhere('status', 'like', "%{$search}%")     // Tìm theo trạng thái
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");  // Tìm theo tên người dùng
                })
                ->orWhereHas('pet', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");  // Tìm theo tên thú cưng
                });
          });
      }

      // Lấy kết quả phân trang
      $serviceBookings = $query->paginate($perPage, ['*'], 'page', $page);

      // Định dạng lại dữ liệu trả về với tên người dùng và tên thú cưng
      $formattedBookings = $serviceBookings->getCollection()->map(function ($booking) {
          return [
              'id' => $booking->id,
              'booking_date' => $booking->booking_date,
              'status' => $booking->status,
              'total_price' => $booking->total_price,
              'user_id' => $booking->user_id,
              'user_name' => $booking->user ? $booking->user->name : null,  // Lấy tên người dùng
              'pet_id' => $booking->pet_id,
              'pet_name' => $booking->pet ? $booking->pet->name : null,    // Lấy tên thú cưng
              'service_id' => $booking->service_id,
              'service_name' => $booking->service ? $booking->service->name : null, // Lấy tên dịch vụ
          ];
      });

      // Trả về kết quả dưới dạng JSON
      return response()->json([
          'data' => $formattedBookings,
          'current_page' => $serviceBookings->currentPage(),
          'last_page' => $serviceBookings->lastPage(),
          'per_page' => $serviceBookings->perPage(),
          'total' => $serviceBookings->total(),
      ], 200);
  }

    // // Lấy một service booking theo ID
    // public function show($id)
    // {
    //     $serviceBooking = ServiceBooking::with(['user', 'pet', 'service'])->find($id);

    //     if (!$serviceBooking) {
    //         return response()->json(['message' => 'Service Booking not found'], 404);
    //     }

    //     return response()->json($serviceBooking);
    // }

    // // Tạo một service booking mới
    // public function store(Request $request)
    // {
    //     // Validate dữ liệu gửi lên
    //     $validatedData = $request->validate([
    //         'booking_date' => 'required|date',
    //         'status' => 'required|string',
    //         'total_pirce' => 'required|numeric',
    //         'user_id' => 'required|exists:users,id',
    //         'pet_id' => 'required|exists:pets,id',
    //         'service_id' => 'required|exists:services,id',
    //     ]);

    //     // Tạo mới service booking
    //     $serviceBooking = ServiceBooking::create($validatedData);

    //     return response()->json($serviceBooking, 201);
    // }

    // // Cập nhật một service booking
    // public function update(Request $request, $id)
    // {
    //     $serviceBooking = ServiceBooking::find($id);

    //     if (!$serviceBooking) {
    //         return response()->json(['message' => 'Service Booking not found'], 404);
    //     }

    //     // Validate dữ liệu cập nhật
    //     $validatedData = $request->validate([
    //         'booking_date' => 'sometimes|date',
    //         'status' => 'sometimes|string',
    //         'total_pirce' => 'sometimes|numeric',
    //         'user_id' => 'sometimes|exists:users,id',
    //         'pet_id' => 'sometimes|exists:pets,id',
    //         'service_id' => 'sometimes|exists:services,id',
    //     ]);

    //     // Cập nhật thông tin
    //     $serviceBooking->update($validatedData);

    //     return response()->json($serviceBooking);
    // }

    // Xóa một service booking
    public function stockin(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);

        // Tạo truy vấn cơ bản cho Stockin
        $query = Stockin::with(['product']); // Giả sử có quan hệ với bảng product

        // Áp dụng tìm kiếm nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('stockin_date', 'like', "%{$search}%") // Tìm theo ngày nhập kho
                  ->orWhere('Quantity', 'like', "%{$search}%")     // Tìm theo số lượng
                  ->orWhereHas('product', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");  // Tìm theo tên sản phẩm
                  });
            });
        }

        // Lấy kết quả phân trang
        $stockEntries = $query->paginate($perPage, ['*'], 'page', $page);

        // Định dạng lại dữ liệu trả về với tên sản phẩm
        $formattedEntries = $stockEntries->getCollection()->map(function ($entry) {
            return [
                'id' => $entry->id,
                'product_id' => $entry->product_id,
                'stockin_date' => $entry->stockin_date,
                'Quantity' => $entry->Quantity,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at,
                'product_name' => $entry->product ? $entry->product->name : null, // Lấy tên sản phẩm
            ];
        });

        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'data' => $formattedEntries,
            'current_page' => $stockEntries->currentPage(),
            'last_page' => $stockEntries->lastPage(),
            'per_page' => $stockEntries->perPage(),
            'total' => $stockEntries->total(),
        ], 200);
    }

 
    /**
     * Tính tổng doanh thu của cả năm và chia doanh thu cho từng tháng.
     *
     * @param int $year Năm cần báo cáo doanh thu.
     * @return array Mảng chứa doanh thu từng tháng trong năm.
     */
    public function getAnnualRevenue($year)
    {
        try {
            // Kiểm tra giá trị của $year
            if (!$year) {
                return response()->json(['error' => 'Year is required'], 400);
            }
    
            // Tính tổng doanh thu của cả năm
            $totalAnnualRevenue = Order::whereYear('created_at', $year)->sum('total_money');
            
            // Ghi nhận tổng doanh thu để kiểm tra
            \Log::info("Total Annual Revenue for year {$year}: {$totalAnnualRevenue}");
    
            // Tạo mảng doanh thu cho từng tháng
            $monthlyRevenue = [];
    
            // Tính doanh thu cho từng tháng
            $monthlyOrders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_money) as total_revenue')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    
            // Ghi nhận doanh thu hàng tháng để kiểm tra
            \Log::info("Monthly Orders for year {$year}: ", $monthlyOrders->toArray());
    
            // Gán doanh thu vào mảng theo từng tháng
            for ($month = 1; $month <= 12; $month++) {
                // Tìm doanh thu của tháng hiện tại, nếu không có thì gán 0
                $revenue = $monthlyOrders->firstWhere('month', $month);
                $monthlyRevenue[$month] = $revenue ? $revenue->total_revenue : 0;
            }
    
            // Trả về tổng doanh thu năm và doanh thu theo từng tháng dưới dạng JSON
            return response()->json([
                'total_annual_revenue' => $totalAnnualRevenue,
                'monthly_revenue' => $monthlyRevenue,
            ]);
        } catch (\Exception $e) {
            // Ghi nhận lỗi nếu có
            \Log::error("Error fetching annual revenue: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    }
    
    