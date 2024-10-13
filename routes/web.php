<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
use Illuminate\Http\Request;
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



Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
// Nhongj
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/product', [AdminController::class, 'product'])->name('product');
    Route::get('/category', [AdminController::class, 'category'])->name('category');
});