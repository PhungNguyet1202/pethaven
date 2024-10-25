<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Phương thức trả về view đăng ký
    public function register(Request $req) {
        return view('user.register'); 
    }

    // Phương thức trả về view đăng nhập
    public function login(Request $req) {
        return view('user.login'); 
    }

    // Phương thức xử lý đăng ký
    public function postregister(Request $req)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|size:10|regex:/^0\d{9}$/',  
                'address' => 'nullable|string|max:255',
            ]);
    
            // Tạo người dùng mới
            User::create([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
                'password' => Hash::make($req->input('password')),
                'phone' => $req->input('phone'),
                'address' => $req->input('address'),
            ]);
    
            // Trả về phản hồi thành công
            return response()->json(['success' => true, 'message' => 'Đăng ký thành công. Vui lòng đăng nhập.']);
        } catch (ValidationException $e) {
            // Trả về thông báo lỗi xác thực
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Trả về thông báo lỗi chung
            return response()->json(['success' => false, 'message' => 'Đăng ký không thành công', 'error' => $e->getMessage()], 500);
        }
    }

    // Phương thức xử lý đăng nhập
    public function postlogin(Request $req) {
        // Xác thực dữ liệu đầu vào
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        // Cố gắng đăng nhập
        $credentials = $req->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Kiểm tra trạng thái tài khoản
            if ($user->is_action == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản của bạn đã bị khóa.'
                ], 403); // Sử dụng mã trạng thái 403 Forbidden
            }
    
            // Nếu đăng nhập thành công và tài khoản không bị khóa
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role // Trả về vai trò của người dùng
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            // Trả về thông báo lỗi nếu thông tin đăng nhập không chính xác
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không đúng',
            ], 401);
        }
    }
    
    
}