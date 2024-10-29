<?php

use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentCotroller; // Đã sửa chính tả
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewsController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route cho trang chủ
Route::get('/', [PageController::class, 'home'])->name('home');

// Route cho đăng xuất
Route::post('/logout', function() {
    Auth::logout();
    return redirect()->route('login'); // Đổi sang route login
})->name('logout');

// Route cho sản phẩm
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::get('/detail/{slug}', [ProductController::class, 'detail'])->name('detail');

// Route cho đăng ký và đăng nhập
Route::get('/register', [UserController::class, 'register'])->name('register'); // Hiển thị trang đăng ký
Route::post('/register', [UserController::class, 'postregister'])->name('postregister'); // Xử lý đăng ký
Route::get('/login', [UserController::class, 'login'])->name('login'); // Hiển thị trang đăng nhập
Route::post('/login', [UserController::class, 'postlogin'])->name('postlogin'); // Xử lý đăng nhập

// Route API
Route::prefix('api')->group(function() {
    // Route cho comments
    Route::get('/comments/product/{product_id}', [CommentCotroller::class, 'product']);
    Route::resource('/comments', CommentCotroller::class);

    // Route cho sản phẩm
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('category');
    Route::get('/product/{productId}/related', [ProductController::class, 'getRelatedProducts']);
    Route::get('/product/{id}/related', [ProductController::class, 'getRelatedProducts']);
    
    Route::middleware('auth')->group(function () {
        // Route cho giỏ hàng
        Route::get('/cart', [CartController::class, 'getCart'])->name('cart.show');
        Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/{cartItemId}', [CartController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

        // Route cho người dùng
        Route::get('/user/profile', [UserController::class, 'showProfile'])->name('showProfile');
        Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('updateProfile'); // Cập nhật thông tin người dùng
    });
});

//dichvu
Route::get('/services', [ServiceController::class, 'index'])->name('service');
Route::get('/services/{identifier}', [ServiceController::class, 'show']); // Lấy chi tiết dịch vụ theo id hoặc slug


//tin tuc
Route::get('/news', [NewsController::class, 'news'])->name('news');
Route::get('/news/{id}', [NewsController::class, 'newsDetail']);


// Route cho quản trị viên
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminApiController::class, 'dashboard'])->name('dashboard');
    Route::get('/product', [AdminApiController::class, 'product'])->name('product');
    Route::get('/category', [AdminApiController::class, 'category'])->name('category');
    Route::get('/user', [AdminApiController::class, 'user'])->name('user');
    Route::get('/categoryNew', [AdminApiController::class, 'categoryNew'])->name('categoryNew');
    Route::get('/news', [AdminApiController::class, 'news'])->name('news');
    Route::get('/pet', [AdminApiController::class, 'pet'])->name('pet');
    Route::get('/comment', [AdminApiController::class, 'comment'])->name('comment');
    Route::get('/service', [AdminApiController::class, 'service'])->name('service');

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/add', [AdminApiController::class, 'productAdd'])->name('add'); // Lấy thông tin danh mục
        Route::post('/add', [AdminApiController::class, 'postproductAdd'])->name('add'); // Thêm sản phẩm mới
        Route::put('/update/{id}', [AdminApiController::class, 'updateProduct'])->name('update'); // Cập nhật sản phẩm
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteProduct'])->name('delete'); // Xóa sản phẩm
    });
});
