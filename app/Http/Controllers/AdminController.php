<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\product;
use App\Models\User;
use App\Models\comment;
use App\Models\stockin;
use App\Models\category;
use App\Models\categorynew;
use App\Models\news;
use App\Models\pet;
use App\Models\services;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(){
         $soDonHang= Order::count();
         $soSanPham= Product::count();
         $soKhachHang = User::where('role', 'user')->count();
         $doanhThu = Order :: where('status','success')->sum('total_money');
         $dsDH = Order :: orderBy('created_at','DESC')->limit(5)->get();
         $dsBL = Comment :: orderBy('created_at','DESC')->limit(5)->get();
        return view('admin.dashboard',compact(['soDonHang','soSanPham','soKhachHang','doanhThu','dsDH','dsBL']));
    }
    public function product() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsSP = Product::with('category')  // Lấy thông tin danh mục
                       ->withSum('stockIns', 'Quantity') // Sử dụng đúng tên phương thức
                       ->paginate(10);
    
        return view('admin.product', compact('dsSP'));
    }
    public function category() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsCT = Category::paginate(10);
    
        return view('admin.category', compact('dsCT'));
    }
    public function user() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsUS = User::paginate(10);
    
        return view('admin.user', compact('dsUS'));
    }
    public function categoryNew() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsCTN = categorynew::paginate(10);
    
        return view('admin.categoryNew', compact('dsCTN'));
    }
    public function news() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsNew = news::with('categorynew')  // Lấy thông tin danh mục
        ->paginate(10);
        return view('admin.news', compact('dsNew'));
    }
    public function pet() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsPet = pet::paginate(10);
    
        return view('admin.pet', compact('dsPet'));
    }
    public function productAdd() {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $dsCT = Category::get();
     
        return view('admin.product_add', compact('dsCT'));
    }
    public function postproductAdd(Request $request) {
        // Lấy tất cả sản phẩm, danh mục của chúng và tổng số lượng tồn kho
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name) ;
        $product ->description = $request->description1;
        $product ->categories_id = $request->category_id;
        $product ->price = $request->price;
        $product ->instock = $request->instock; 
        $product ->sale_price = $request->sale_price;
        $product ->image = '';
        $product ->save();
        if($request->hasFile('image'))
        {
            $img = $request->file('image');
            $imgName = trim("{$product->id}.{$img->getClientOriginalExtension()}");
            $img->move(public_path('images/products/'),$imgName);
            $product ->image = $imgName;
            $product ->save();
        }
        return redirect() ->route('admin.product');
        // return view('admin.product_add', compact('dsCT'));
    }
}