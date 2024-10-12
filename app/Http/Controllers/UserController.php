<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; // Đảm bảo import Request
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Đảm bảo import Auth

class UserController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login() {
        return view('user.login'); 
    }

    // Hiển thị trang đăng ký
    public function register() {
        return view('user.register'); 
    }

    // Xử lý đăng ký người dùng mới
    public function postregister(Request $req) {
        // Validate dữ liệu đầu vào
        $req->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        // Tạo người dùng mới
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone' => $req->phone,
            'address' => $req->address,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!'); // Đăng ký thành công
    }

    // Xử lý đăng nhập người dùng
    public function postlogin(Request $req) {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kiểm tra đăng nhập
        if (Auth::attempt($req->only('email', 'password'))) {
            return redirect()->route('home');
        }

        return back()->withErrors(['message' => 'Email hoặc mật khẩu không đúng!']); // Thông báo lỗi
    }

    // Hiển thị thông tin người dùng hiện tại
    public function profile() {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        return view('user.profile', compact('user')); // Trả về view với thông tin người dùng
    }
    
    // Hiển thị thông tin người dùng hiện tại dưới dạng JSON
    public function showProfile() {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        return response()->json($user); // Trả về thông tin người dùng dưới dạng JSON
    }

    // Cập nhật thông tin người dùng
    public function updateProfile(Request $req) {
        $user = Auth::user(); // Lấy người dùng hiện tại
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401); // Người dùng chưa đăng nhập
        }
    
        // Validate dữ liệu đầu vào
        $validatedData = $req->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'img' => 'nullable|string|max:255',

        ]);
    
        // Cập nhật thông tin
        $user->name = $validatedData['name'] ?? $user->name;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->phone = $validatedData['phone'] ?? $user->phone;
        $user->address = $validatedData['address'] ?? $user->address;
        $user->img = $validatedData['img'] ?? $user->img;

    
        // Cập nhật mật khẩu nếu có
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
    
        $user->save(); // Lưu thông tin cập nhật
    
        return response()->json(['message' => 'User information updated successfully']);
    }
    
}
