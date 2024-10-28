<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentCotroller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentAdminController;
use App\Http\Controllers\ServiceAdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewAdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\UserAdminController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::post('/test-csrf', function () {
    return response()->json(['message' => 'CSRF token is valid!']);
});
Route::prefix('api')->group(function() {
//     Route::get('/comments/product/{product_id}', [CommentCotroller::class, 'product']);
//     Route::resource('/comments', CommentCotroller::class);
//     Route::post('/login', [UserController::class, 'postlogin']);
//     Route::post('/register', [UserController::class, 'postregister']);
//     Route::get('/product', [ProductController::class, 'product'])->name('product');
//    // Route::get('/detail/{slug}', [ProductController::class,'detail'])->name('detail');
//    //Route::get('/detail/{slug}', [ProductController::class, 'detail'])->name('product.detail');
//    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
//     Route::get('/register', [UserController::class, 'register'])->name('register');
//     Route::get('/login', [UserController::class, 'login'])->name('login');
//     // Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('category');
//     Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('category');
Route::get('/comments/product/{product_id}', [CommentCotroller::class, 'product']);
    Route::resource('/comments', CommentCotroller::class);
    Route::post('/login', [UserController::class, 'postlogin']);
    Route::post('/register', [UserController::class, 'postregister']);
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/products', [ProductController::class, 'product']);
    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('api.category');
    Route::get('/product/search', [ProductController::class, 'product']);
    Route::get('/product/{productId}/related', [ProductController::class, 'getRelatedProducts']);
    Route::get('/product/{id}/related', [ProductController::class, 'getRelatedProducts']);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
//dichvu
Route::get('/services', [ServiceController::class, 'index'])->name('service');
Route::get('/services/{identifier}', [ServiceController::class, 'show']); // Lấy chi tiết dịch vụ theo id hoặc slug
//tin tuc
Route::get('/news', [NewsController::class, 'news'])->name('news');
Route::get('/news/{id}', [NewsController::class, 'newsDetail']);
});

//cal
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
// Nhongj
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/product-category', [AdminApiController::class, 'productCategory'])->name('product-category'); // Form thêm sản phẩm mới

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [AdminApiController::class, 'dashboard'])->name('index'); // Danh sách sản phẩm

    });

    // Product Routes
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [AdminApiController::class, 'product'])->name('index'); // Danh sách sản phẩm
        Route::get('/{id}', [AdminApiController::class, 'getProductById'])->name('show');

        Route::post('/add', [AdminApiController::class, 'postproductAdd'])->name('add'); // Thêm sản phẩm mới
        Route::put('/update/{id}', [AdminApiController::class, 'updateProduct'])->name('update'); // Cập nhật sản phẩm
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteProduct'])->name('delete'); // Xóa sản phẩm
    });

    Route::prefix('api')->group(function () {
        Route::get('/cart', [CartController::class, 'getCart']);
        Route::post('/cart/add', [CartController::class, 'addToCart']);
        Route::put('/cart/update/{id}', [CartController::class, 'updateCart']);
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
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
        Route::get('/', [AdminApiController::class, 'users'])->name('index'); // Danh sách user
        Route::get('/{id}', [AdminApiController::class, 'getUserById'])->name('show');
        Route::put('/update/{id}', [AdminApiController::class, 'updateUser'])->name('update'); // Cập nhật user

    });

    // CategoryNew Routes
    Route::prefix('categoryNew')->name('categoryNew.')->group(function () {
        Route::get('/', [AdminApiController::class, 'categoryNew'])->name('index'); // Danh sách categoryNew
        Route::get('/{id}', [AdminApiController::class, 'getCategoryNewById'])->name('show');
        Route::get('/create', [AdminApiController::class, 'categoryNewCreate'])->name('create'); // Form thêm categoryNew mới
        Route::post('/add', [AdminApiController::class, 'postCategoryNewAdd'])->name('add'); // Thêm categoryNew mới
        Route::put('/update/{id}', [AdminApiController ::class, 'updateCategoryNew'])->name('update'); // Cập nhật categoryNew
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteCategoryNew'])->name('delete'); // Xóa categoryNew
    });

    // News Routes
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [AdminApiController::class, 'news'])->name('index'); // Danh sách news
        Route::get('/{id}', [AdminApiController::class, 'getNewById'])->name('show');
        Route::get('/create', [AdminApiController::class, 'newsCreate'])->name('create'); // Form thêm news mới
        Route::post('/add', [AdminApiController::class, 'postNewsAdd'])->name('add'); // Thêm news mới
        Route::put('/update/{id}', [AdminApiController::class, 'updateNews'])->name('update'); // Cập nhật news
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteNews'])->name('delete'); // Xóa news
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
        Route::get('/', [AdminApiController::class, 'comment'])->name('index'); // Danh sách comment

        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteComment'])->name('delete'); // Xóa comment
    });

    // Service Routes
    Route::prefix('service')->name('service.')->group(function () {
        Route::get('/', [AdminApiController::class, 'service'])->name('index'); // Danh sách service
        Route::get('/{id}', [AdminApiController::class, 'getServiceById'])->name('show');
        Route::get('/create', [AdminApiController::class, 'serviceCreate'])->name('create'); // Form thêm service mới
        Route::post('/add', [AdminApiController::class, 'serviceAdd'])->name('add'); // Thêm service mới
        Route::put('/update/{id}', [AdminApiController::class, 'serviceUpdate'])->name('update'); // Cập nhật service
        Route::delete('/delete/{id}', [AdminApiController::class, 'serviceDelete'])->name('delete'); // Xóa service
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [AdminApiController::class, 'orders'])->name('index'); // Danh sách comment

        Route::put('/update/{id}', [AdminApiController ::class, 'updateOrder'])->name('update'); // Cập nhật categoryNew
    });
    Route::prefix('servicebooking')->name('servicebooking.')->group(function () {
        Route::get('/', [AdminApiController::class, 'serviceBooking'])->name('index'); // Danh sách comment

        Route::put('/update/{id}', [AdminApiController ::class, 'updateOrder'])->name('update'); // Cập nhật categoryNew
    });
    Route::prefix('stockin')->name('stockin.')->group(function () {
        Route::get('/', [AdminApiController::class, 'stockin'])->name('index'); // Danh sách comment

        Route::put('/update/{id}', [AdminApiController ::class, 'updateOrder'])->name('update'); // Cập nhật categoryNew
    });
    Route::prefix('revenue')->name('revenue.')->group(function () {
        Route::get('/{year}', [AdminApiController::class, 'getAnnualRevenue'])->name('index'); // Danh sách comment


    });


});






