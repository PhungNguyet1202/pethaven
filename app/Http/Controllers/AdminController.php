<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard(){
         $soDonHang= Order::count();
         $soSanPham= Product::count();
         $soKhachHang = User::where('role', 'user')->count();

         $doanhThu = Order :: where('status','success')->sum('total_money');
        return view('admin.dashboard',compact(['soDonHang','soSanPham','soKhachHang','doanhThu']));
    }
}