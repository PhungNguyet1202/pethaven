<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Hiển thị form đăng ký
    public function register(Request $req) {
        return view('user.register'); 
    }

    // Hiển thị form đăng nhập
    public function login(Request $req) {
        return view('user.login'); 
    }

    // Xử lý đăng ký người dùng
    public function postregister(Request $req)
    {
        try {
            // Validate input
            $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'dob' => 'required|date',
            ]);

            // Tạo người dùng mới
            $user = new User();
            $user->name = $req->input('name');
            $user->email = $req->input('email');
            $user->password = Hash::make($req->input('password'));
            $user->phone = $req->input('phone');
            $user->address = $req->input('address');
            $user->dob = $req->input('dob');
            $user->save();

            // Redirect đến trang đăng nhập với thông báo thành công
            return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đăng ký thất bại', 'error' => $e->getMessage()], 500);
        }
    }

    // Xử lý đăng nhập người dùng
    public function postlogin(Request $req) {
        // Validate input
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in
        if (Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])) {
            // Redirect đến trang chính với thông báo thành công
            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        }

        // Nếu đăng nhập thất bại, trả về với thông báo lỗi
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!'])->withInput();
    }

    // Hiển thị thông tin người dùng hiện tại
    public function profile() {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        return view('user.profile', compact('user')); // Trả về view với thông tin người dùng
    }

    // Hiển thị thông tin người dùng hiện tại dưới dạng JSON
    public function showProfile()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa có người dùng nào được xác thực'], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'message' => 'Lấy thông tin người dùng thành công'
        ]);
    }

    // Cập nhật thông tin người dùng
    public function updateProfile(Request $req)
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return response()->json(['message' => 'Không có quyền truy cập'], 401);
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

        // Cập nhật thông tin cá nhân
        $user->name = $validatedData['name'] ?? $user->name;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->phone = $validatedData['phone'] ?? $user->phone;
        $user->address = $validatedData['address'] ?? $user->address;
        $user->img = $validatedData['img'] ?? $user->img;

        // Cập nhật mật khẩu nếu có
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Lưu thông tin cập nhật
        $user->save();

        return response()->json(['message' => 'Cập nhật thông tin thành công!', 'user' => $user], 200);
    }
}
