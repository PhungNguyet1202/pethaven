<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $req) {
        return view('user.register'); 
    }

    public function login(Request $req) {
        return view('user.login'); 
    }


    public function postregister(Request $req)
{
    try {
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|size:10|regex:/^0\d{9}$/',
            'address' => 'nullable|string|max:255',
        ]);

        // Create new user
        $user = new User();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->phone = $req->input('phone');
        $user->address = $req->input('address');
        $user->save();

        return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
    }
}

    


    public function postlogin(Request $req) {
       
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
     
        if (Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])) {
            
            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        }
    
       
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!'])->withInput();
    }
    
    public function profile()
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return view('user.profile', ['user' => $user]);
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
    
        // Trả về view 'user.profile' hoặc JSON response
        return view('user.profile', ['user' => $user]); // Render view user.profile
        // OR if you're returning JSON, comment the above line and use the line below:
        return response()->json(['message' => 'Cập nhập thành công!']);
    }
    

    
    // public function postlogin(Request $req) {
    //     // Validate input
    //     $req->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     // Attempt to log in
    //     if (Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])) {
    //         $user = Auth::user();
    //         return response()->json(['message' => 'Đăng nhập thành công', 'user' => $user], 200);
    //     }

    //     return response()->json(['message' => 'Email hoặc mật khẩu không đúng!'], 401);
    // }

}
