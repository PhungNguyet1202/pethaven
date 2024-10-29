<?php
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentCotroller; // Đã sửa chính tả
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
//Route::get('/register', [UserController::class, 'register'])->name('register');


//Route::get('/login', [UserController::class, 'login'])->name('login');


Route::post('/logout',function(){
    Auth::logout();
    return redirect()->route('register');
})->name('logout');


//Route::get('/product', [ProductController::class, 'product'])->name('product');
//Route::get('/detail/{slug}', [ProductController::class,'detail'])->name('detail');

Route::get('/product', [ProductController::class, 'product'])->name('product');

Route::get('/detail/{slug}', [ProductController::class,'detail'])->name('detail');


// Route::prefix('api')->group(function(){
// Route::get('/comments/product/{product_id}',[CommentCotroller::class,'product']);
// Route::resource('/comments', CommentCotroller::class);
// Route::post('/login', [UserController::class,'postlogin']);
// Route::post('/register', [UserController::class,'postregister']);
// }
// );


Route::prefix('api')->group(function() {
    Route::get('/comments/product/{product_id}', [CommentCotroller::class, 'product']);
    Route::resource('/comments', CommentCotroller::class);

    // Route cho sản phẩm
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::get('/detail/{slug}', [ProductController::class,'detail'])->name('detail');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    // Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('category');
    Route::get('/category/{slug}', [ProductController::class, 'productsByCategory'])->name('category');

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
        Route::get('/', [AdminApiController::class, 'product'])->name('index'); // Danh sách sản phẩm
        Route::get('/{id}', [AdminApiController::class, 'getProductById'])->name('show');

        Route::post('/add', [AdminApiController::class, 'postproductAdd'])->name('add'); // Thêm sản phẩm mới
        Route::put('/update/{id}', [AdminApiController::class, 'updateProduct'])->name('update'); // Cập nhật sản phẩm
        Route::delete('/delete/{id}', [AdminApiController::class, 'deleteProduct'])->name('delete'); // Xóa sản phẩm
    });
    
});
    