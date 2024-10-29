<?php
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentCotroller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class,'postregister']);

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class,'postlogin']);

Route::post('/logout',function(){
    Auth::logout();
    return redirect()->route('register');
})->name('logout');

Route::get('/product', [ProductController::class, 'product'])->name('product');

Route::get('/detail/{slug}', [ProductController::class,'detail'])->name('detail');

Route::prefix('api')->group(function(){
Route::get('/comments/product/{product_id}',[CommentCotroller::class,'product']);
Route::resource('/comments', CommentCotroller::class);

});
//cal
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
// Nhongj
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

        // Đường dẫn để cập nhật sản phẩm
        Route::put('/update/{id}', [AdminApiController::class, 'updateProduct'])->name('update'); // Cập nhật sản phẩm

        // Đường dẫn để xóa sản phẩm
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteProduct'])->name('delete'); // Xóa sản phẩm
    });
    
});
    