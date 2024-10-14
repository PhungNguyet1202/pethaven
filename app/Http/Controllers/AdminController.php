<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\product;
use App\Models\User;
use App\Models\comment;
use App\Models\stockin;
use App\Models\category;


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
}