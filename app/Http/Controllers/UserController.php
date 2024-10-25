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

    // Hiển thị form đăng ký

    public function register(Request $req) {
        return view('user.register'); 
    }

    // Phương thức trả về view đăng nhập

    // Hiển thị form đăng nhập

    public function login(Request $req) {
        return view('user.login'); 
    }


    // Phương thức xử lý đăng ký

    // Xử lý đăng ký người dùng

    // public function postregister(Request $req)
    // {
    //     try {
    //         // Xác thực dữ liệu đầu vào
    //         $req->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:users',
    //             'password' => 'required|string|min:8|confirmed',
    //             'phone' => 'required|string|size:10|regex:/^0\d{9}$/',  
    //             'address' => 'nullable|string|max:255',
    //             'dob' => 'required|date',
                
    //         ]);
    

    //         // Tạo người dùng mới
    //         User::create([
    //             'name' => $req->input('name'),
    //             'email' => $req->input('email'),
    //             'password' => Hash::make($req->input('password')),
    //             'phone' => $req->input('phone'),
    //             'address' => $req->input('address'),
    //         ]);

    //         // Create new user
    //         $user = new User();
    //         $user->name = $req->input('name');
    //         $user->email = $req->input('email');
    //         $user->password = Hash::make($req->input('password'));
    //         $user->phone = $req->input('phone');
    //         $user->address = $req->input('address');
    //         $user->dob = $req->input('dob');
    //         $user->save();

    
    //         // Trả về phản hồi thành công
    //         return response()->json(['success' => true, 'message' => 'Đăng ký thành công. Vui lòng đăng nhập.']);
    //     } catch (ValidationException $e) {
    //         // Trả về thông báo lỗi xác thực
    //         return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    //     } catch (\Exception $e) {
    //         // Trả về thông báo lỗi chung
    //         return response()->json(['success' => false, 'message' => 'Đăng ký không thành công', 'error' => $e->getMessage()], 500);
    //     }
    // }

    // // Phương thức xử lý đăng nhập
    // public function postlogin(Request $req) {

    //     // Xác thực dữ liệu đầu vào

       

    //     $req->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);
    
    //     // Cố gắng đăng nhập
    //     $credentials = $req->only('email', 'password');
    
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    
    //         // Kiểm tra trạng thái tài khoản
    //         if ($user->is_action == 1) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Tài khoản của bạn đã bị khóa.'
    //             ], 403); // Sử dụng mã trạng thái 403 Forbidden
    //         }
    
    //         // Nếu đăng nhập thành công và tài khoản không bị khóa
    //         $token = $user->createToken('auth_token')->plainTextToken;
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Đăng nhập thành công',
    //             'user' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'role' => $user->role // Trả về vai trò của người dùng
    //             ],
    //             'access_token' => $token,
    //             'token_type' => 'Bearer',
    //         ]);
    //     } else {
    //         // Trả về thông báo lỗi nếu thông tin đăng nhập không chính xác
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email hoặc mật khẩu không đúng',
    //         ], 401);
    //     }
    // }
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
        
                // Create new user
                $user = new User();
                $user->name = $req->input('name');
                $user->email = $req->input('email');
                $user->password = Hash::make($req->input('password'));
                $user->phone = $req->input('phone');
                $user->address = $req->input('address');
                $user->dob = $req->input('dob');
                $user->save();
        
                // Redirect to login page with success message
                return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['errors' => $e->errors()], 422);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
            }
    
        }
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



//////////
   // Hiển thị thông tin người dùng hiện tại
   public function profile() {
    $user = Auth::user(); // Lấy thông tin người dùng hiện tại
    return view('user.profile', compact('user')); // Trả về view với thông tin người dùng
}

// public function profile()
//     {
//         $user = Auth::user(); // Lấy thông tin người dùng hiện tại
//         if (!$user) {
//             return response()->json(['message' => 'Unauthorized'], 401);
//         }

//         return view('user.profile', ['user' => $user]);
//     }
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