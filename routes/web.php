<?php
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentCotroller; // Đã sửa chính tả
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentAdminController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\ServiceAdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewAdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\StockInAdminController;
use App\Models\Product;


use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::post('/test-csrf', function () {
    return response()->json(['message' => 'CSRF token is valid!']);
});

Route::prefix('api')->group(function() {
    Route::get('/comments/product/{product_id}', [CommentCotroller::class, 'product']);
    Route::resource('/comments', CommentCotroller::class);
    Route::post('/login', [UserController::class, 'postlogin'])->name('login');
    Route::post('/register', [UserController::class, 'postregister']);
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/products', [ProductController::class, 'product']);
    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('api.category');
    Route::get('/product/search', [ProductController::class, 'product']);
    Route::get('/product/{id}/related', [ProductController::class, 'getRelatedProducts']);

    // Dịch vụ
    Route::get('/services', [ServiceController::class, 'index'])->name('service');
    Route::get('/services/{identifier}', [ServiceController::class, 'show']);
    Route::post('/service-booking', [ServiceController::class, 'serviceBooking']);
    Route::get('pets', [ServiceController::class, 'getAllPets']);
    Route::get('/booking-history', [ServiceController::class, 'bookingHistory']);

    Route::post('/booking/{bookingId}/cancel', [ServiceController::class, 'cancelBooking']);


    // Tin tức
    Route::get('/news', [NewsController::class, 'news'])->name('news');
    Route::get('/news/{id}', [NewsController::class, 'newsDetail']);
    Route::get('/user/profile/{userId}', [UserController::class, 'showProfile'])->name('showProfile');
    Route::put('/user/profile/{userId}', [UserController::class, 'updateProfile'])->name('updateProfile');
   // Route::middleware('auth:sanctum')->get('/booking-history', [ServiceController::class, 'bookingHistory']);
   // Lấy tất cả đánh giá của một sản phẩm
   Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);
   Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);

   Route::post('/createOrder', [OrderController::class, 'createOrder']);
    // quên mk
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
});

// Người dùng & Giỏ hàng (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'getCart'])->name('cart.show');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{cartItemId}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');


    // Đảm bảo route có tham số {userId}

});

// Route::get('/profile', [UserController::class, 'profile'])->name('profile');
// Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
// Nhongj

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/revenue-last-7-days', [ReportController::class, 'getRevenueLast7Days'])->name('report'); // Danh sách comment
    Route::get('/revenuemonth/{year}/{month}', [ReportController::class, 'getMonthlyRevenue'])->name('reportmonth'); // Danh sách comment
    Route::get('/product-category', [AdminApiController::class, 'productCategory'])->name('product-category'); // Form thêm sản phẩm mới
    Route::get('/new-category', [AdminApiController::class, 'newCategory'])->name('new-category'); // Form thêm sản phẩm mới
    Route::get('/get-product', [StockInAdminController::class, 'getProducts'])->name('get-product'); // Form thêm sản phẩm mới
    Route::get('/updateaction', [AdminApiController::class, 'updateUserStatusBasedOnCancelledOrders'])->name('updateUserStatusBasedOnCancelledOrders'); // Danh sách user
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [AdminApiController::class, 'dashboard'])->name('index'); // Danh sách sản phẩm

    });

    // Product Routes
    Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductAdminController::class, 'product'])->name('index'); // Danh sách sản phẩm
        Route::get('/{id}', [ProductAdminController::class, 'getProductById'])->name('show');
        Route::post('/add', [ProductAdminController::class, 'postproductAdd'])->name('add'); // Thêm sản phẩm mới
        Route::put('/update/{id}', [ProductAdminController::class, 'updateProduct'])->name('update'); // Cập nhật sản phẩm
        Route::delete('/delete/{id}', [ProductAdminController::class, 'deleteProduct'])->name('delete'); // Xóa sản phẩm
    });

    // Category Routes
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [AdminApiController::class, 'category'])->name('index'); // Danh sách category
        Route::get('/{id}', [AdminApiController::class, 'getCategoryById'])->name('show');
        Route::get('/create', [AdminApiController::class, 'categoryCreate'])->name('create'); // Form thêm category mới
        Route::post('/add', [AdminApiController::class, 'postCategoryAdd'])->name('add'); // Thêm category mới
        Route::put('/update/{id}', [AdminApiController::class, 'updateCategory'])->name('update'); // Cập nhật category
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteCategory'])->name('delete'); // Xóa category
    });

    // User Routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserAdminController::class, 'users'])->name('index'); // Danh sách user
        Route::get('/{id}', [UserAdminController::class, 'getUserById'])->name('show');
        Route::put('/update/{id}', [UserAdminController::class, 'updateUser'])->name('update'); // Cập nhật user

    });

    // CategoryNew Routes
    Route::prefix('categoryNew')->name('categoryNew.')->group(function () {
        Route::get('/', [NewsAdminController::class, 'categoryNew'])->name('index'); // Danh sách categoryNew
        Route::get('/{id}', [NewsAdminController::class, 'getCategoryNewById'])->name('show');
        Route::get('/create', [NewsAdminController::class, 'categoryNewCreate'])->name('create'); // Form thêm categoryNew mới
        Route::post('/add', [NewsAdminController::class, 'postCategoryNewAdd'])->name('add'); // Thêm categoryNew mới
        Route::put('/update/{id}', [NewsAdminController ::class, 'updateCategoryNew'])->name('update'); // Cập nhật categoryNew
        Route::delete('/delete/{id}', [NewsAdminController::class, 'deleteCategoryNew'])->name('delete'); // Xóa categoryNew
    });

    // News Routes
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsAdminController::class, 'news'])->name('index'); // Danh sách news
        Route::get('/{id}', [NewsAdminController::class, 'getNewById'])->name('show');
        Route::get('/create', [NewsAdminController::class, 'newsCreate'])->name('create'); // Form thêm news mới
        Route::post('/add', [NewsAdminController::class, 'postNewsAdd'])->name('add'); // Thêm news mới
        Route::put('/update/{id}', [NewsAdminController::class, 'updateNews'])->name('update'); // Cập nhật news
        Route::delete('/delete/{id}', [NewsAdminController::class, 'deleteNews'])->name('delete'); // Xóa news
    });

    // Pet Routes
    Route::prefix('pet')->name('pet.')->group(function () {
        Route::get('/', [AdminApiController::class, 'pet'])->name('index'); // Danh sách pet
        Route::get('/{id}', [AdminApiController::class, 'getPetById'])->name('show');
        Route::get('/create', [AdminApiController::class, 'petCreate'])->name('create'); // Form thêm pet mới
        Route::post('/add', [AdminApiController::class, 'postPetAdd'])->name('add'); // Thêm pet mới
        Route::put('/update/{id}', [AdminApiController::class, 'updatePet'])->name('update'); // Cập nhật pet
        Route::delete('/delete/{id}', [AdminApiController::class, 'petDelete'])->name('delete'); // Xóa pet
    });

    // Comment Routes
    Route::prefix('comment')->name('comment.')->group(function () {
        Route::get('/', [CommentCotroller::class, 'comment'])->name('index'); // Danh sách comment

        Route::delete('/delete/{id}', [CommentCotroller::class, 'deleteComment'])->name('delete'); // Xóa comment
    });

    // Service Routes
    Route::prefix('service')->name('service.')->group(function () {
        Route::get('/', [ServiceAdminController::class, 'service'])->name('index'); // Danh sách service
        Route::get('/{id}', [ServiceAdminController::class, 'getServiceById'])->name('show');
        Route::get('/create', [ServiceAdminController::class, 'serviceCreate'])->name('create'); // Form thêm service mới
        Route::post('/add', [ServiceAdminController::class, 'postServiceAdd'])->name('add'); // Thêm service mới
        Route::put('/update/{id}', [ServiceAdminController::class, 'updateService'])->name('update'); // Cập nhật service
        Route::delete('/delete/{id}', [ServiceAdminController::class, 'deleteService'])->name('delete'); // Xóa service
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [OrderAdminController::class, 'orders'])->name('index'); // Danh sách comment

        Route::put('/update/{id}', [OrderAdminController ::class, 'updateOrder'])->name('update'); // Cập nhật categoryNew
    });
    Route::prefix('servicebooking')->name('servicebooking.')->group(function () {
        Route::get('/', [ServiceAdminController::class, 'serviceBooking'])->name('index'); // Danh sách comment
        Route::get('/{id}', [ServiceAdminController::class, 'getServiceBookingById'])->name('show'); // Danh sách comment
        Route::put('/update/{id}', [ServiceAdminController ::class, 'updateStatusServicebooking'])->name('update'); // Cập nhật categoryNew
    });
    Route::prefix('stockin')->name('stockin.')->group(function () {
        Route::get('/', [StockInAdminController::class, 'stockin'])->name('index'); // Danh sách comment
        Route::get('/{id}', [StockInAdminController::class, 'gettStockinById'])->name('show'); // Danh sách comment
        Route::post('/add', [StockInAdminController::class, 'postStockEntry'])->name('add'); // Thêm service mới
        Route::put('/update/{id}', [StockInAdminController::class, 'updateStockEntry'])->name('update'); // Cập nhật service
        Route::delete('/delete/{id}', [StockInAdminController::class, 'deleteStockEntry'])->name('delete'); // Xóa service
    });
    Route::prefix('revenue')->name('revenue.')->group(function () {
        Route::get('/order/year/{year}', [ReportController::class, 'getAnnualRevenue'])->name('indexorder'); // Danh sách comment
        Route::get('/order/revenue-last-7-days', [ReportController::class, 'getRevenueLast7Days'])->name('reportorder'); // Danh sách comment
        Route::get('/order/revenuemonth/{year}/{month}', [ReportController::class, 'getMonthlyRevenue'])->name('reportmonthorder'); // Danh sách comment
        Route::get('/service/year/{year}', [ReportController::class, 'getAnnualServiceRevenue'])->name('indexservice'); // Danh sách comment
        Route::get('/service/revenue-last-7-days', [ReportController::class, 'getServiceRevenueLast7Days'])->name('reportservice'); // Danh sách comment
        Route::get('/service/revenuemonth/{year}/{month}', [ReportController::class, 'getMonthlyServiceRevenue'])->name('reportmonthservice'); // Danh sách comment
        Route::get('/total/year/{year}', [ReportController::class, 'getTotalRevenueByMonthInYear'])->name('indextotal'); // Danh sách comment
        Route::get('/total/revenue-last-7-days', [ReportController::class, 'getTotalRevenueLast7Days'])->name('reporttotal'); // Danh sách comment
        Route::get('/total/revenuemonth/{year}/{month}', [ReportController::class, 'getTotalRevenueByDayInMonth'])->name('reportmonthtotal'); // Danh sách comment
    });
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/product', [ReportController::class, 'getTopSellingProducts'])->name('index'); // Danh sách comment


    });




});
