<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đăng ký không thành công', 'error' => $e->getMessage()], 500);
        }
    }

    // Phương thức xử lý đăng nhập chưa check quên mk
    // public function postlogin(Request $req) {
    //     // Xác thực dữ liệu đầu vào
    //     $req->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //         'remember' => 'sometimes|boolean', // Xác thực remember nếu được gửi
    //     ]);

    //     // Lấy thông tin đăng nhập và giá trị "remember"
    //     $credentials = $req->only('email', 'password');
    //     $remember = $req->input('remember', false); // Giá trị mặc định là false

    //     if (Auth::attempt($credentials, $remember)) { // Truyền $remember vào Auth::attempt
    //         $user = Auth::user();

    //         // Kiểm tra trạng thái tài khoản
    //         if ($user->is_action == 1) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Tài khoản của bạn đã bị khóa.'
    //             ], 403);
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
    //                 'role' => $user->role
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

    public function postlogin(Request $req)
    {
        // Xác thực dữ liệu đầu vào
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean', // Xác thực remember nếu được gửi
        ]);

        // Lấy thông tin đăng nhập và giá trị "remember"
        $credentials = $req->only('email', 'password');
        $remember = $req->input('remember', false); // Giá trị mặc định là false

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials, $remember)) { // Truyền $remember vào Auth::attempt
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if ($user->is_action == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản của bạn đã bị khóa.'
                ], 403);
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
                    'role' => $user->role
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Kiểm tra xem người dùng có đặt lại mật khẩu không (vấn đề với mật khẩu cũ)
        $user = User::where('email', $req->email)->first();
        if ($user) {
            if (Hash::check($req->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email hoặc mật khẩu đã thay đổi. Hãy thử lại với mật khẩu mới.',
                ], 401);
            }
        }

        // Trả về thông báo lỗi nếu thông tin đăng nhập không chính xác
        return response()->json([
            'success' => false,
            'message' => 'Email hoặc mật khẩu không đúng',
        ], 401);
    }

    public function forgotPassword(Request $req)
{
    $req->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $req->email)->first();

    // Tạo mã OTP ngẫu nhiên
    $otp = random_int(100000, 999999);
    $user->otp_code = Hash::make($otp); // Lưu OTP dưới dạng mã hóa
    $user->otp_expires_at = now()->addMinutes(10);
    $user->save();

    // Gửi OTP qua email
    try {
        Mail::send([], [], function ($message) use ($user, $otp) {
            $message->to($user->email)
                    ->subject('Mã OTP đặt lại mật khẩu')
                    ->html("Mã OTP của bạn là: <b>$otp</b>. Mã này sẽ hết hạn sau 10 phút.");
        });
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Không thể gửi email.',
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'OTP đã được gửi đến email của bạn.',
    ]);
}

public function verifyOtp(Request $req)
{
    $req->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|string',
    ]);

    $user = User::where('email', $req->email)->first();

    // Kiểm tra mã OTP
    if (!$user || !Hash::check($req->otp, $user->otp_code) || now()->greaterThan($user->otp_expires_at)) {
        return response()->json([
            'success' => false,
            'message' => 'OTP không hợp lệ hoặc đã hết hạn.',
        ], 400);
    }

    return response()->json([
        'success' => true,
        'message' => 'OTP hợp lệ, bạn có thể đặt lại mật khẩu.',
    ]);
}

public function resetPassword(Request $req)
{
    $req->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|string',
        'password' => 'required|string|confirmed|min:8',
    ]);

    $user = User::where('email', $req->email)->first();

    // Kiểm tra mã OTP
    if (!$user || !Hash::check($req->otp, $user->otp_code) || now()->greaterThan($user->otp_expires_at)) {
        return response()->json([
            'success' => false,
            'message' => 'OTP không hợp lệ hoặc đã hết hạn.',
        ], 400);
    }

    // Cập nhật mật khẩu và xóa trường OTP
    $user->password = Hash::make($req->password);
    $user->otp_code = null;
    $user->otp_expires_at = null;
    $user->save();

    // Đăng xuất các thiết bị khác với mật khẩu mới
    Auth::logoutOtherDevices($req->password);

    return response()->json([
        'success' => true,
        'message' => 'Mật khẩu đã được đặt lại thành công.',
    ]);
}

    // public function postregister(Request $req)

    // {
    //     try {
    //         $req->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:users',
    //             'password' => 'required|string|min:8|confirmed',
    //             'phone' => 'required|string|size:10|regex:/^0\d{9}$/',
    //             'address' => 'nullable|string|max:255',

    //         ]);

    //         // Create new user
    //         $user = new User();
    //         $user->name = $req->input('name');
    //         $user->email = $req->input('email');
    //         $user->password = Hash::make($req->input('password'));
    //         $user->phone = $req->input('phone');
    //         $user->address = $req->input('address');

    //         $user->save();

    //         return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json(['errors' => $e->errors()], 422);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
    //     {
    //         try {
    //             // Validate input
    //             $req->validate([
    //                 'name' => 'required|string|max:255',
    //                 'email' => 'required|string|email|max:255|unique:users',
    //                 'password' => 'required|string|min:8|confirmed',
    //                 'phone' => 'required|string|max:15',
    //                 'address' => 'nullable|string|max:255',
    //                 'dob' => 'required|date',

    //             ]);

    //             // Create new user
    //             $user = new User();
    //             $user->name = $req->input('name');
    //             $user->email = $req->input('email');
    //             $user->password = Hash::make($req->input('password'));
    //             $user->phone = $req->input('phone');
    //             $user->address = $req->input('address');
    //             $user->dob = $req->input('dob');
    //             $user->save();

    //             // Redirect to login page with success message
    //             return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    //         } catch (\Illuminate\Validation\ValidationException $e) {
    //             return response()->json(['errors' => $e->errors()], 422);
    //         } catch (\Exception $e) {
    //             return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
    //         }

    //     }
    // }
    // }



        // public function postlogin(Request $req) {

        //     $req->validate([
        //         'email' => 'required|string|email',
        //         'password' => 'required|string',
        //     ]);


        //     if (Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])) {

        //         return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        //     }


        //     return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!'])->withInput();
        // }



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
public function showProfile($userId)
{
    // Tìm người dùng theo ID
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json($user); // Trả về thông tin người dùng
}


public function updateProfile(Request $request, $userId)
{
    // Tìm người dùng theo ID
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Xác thực dữ liệu
    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:15',
        'gender' => 'nullable|string|max:10|in:male,female,other',
        'birthdate' => 'nullable|date',

    ]);

    // Cập nhật thông tin khác
    $user->name = $validatedData['name'] ?? $user->name;
    $user->email = $validatedData['email'] ?? $user->email;
    $user->phone = $validatedData['phone'] ?? $user->phone;
    $user->gender = $validatedData['gender'] ?? $user->gender;
    $user->birthdate = $validatedData['birthdate'] ?? $user->birthdate;

    // Xử lý ảnh nếu có tải lên
    if ($request->hasFile('img')) {
        $img = $request->file('img');
        $imgName = "{$user->id}." . $img->getClientOriginalExtension();
        $destinationPath = public_path('images/user');

        // Xóa ảnh cũ nếu có
        if ($user->img && file_exists("$destinationPath/{$user->img}")) {
            unlink("$destinationPath/{$user->img}");
        }

        // Lưu ảnh mới
        $img->move($destinationPath, $imgName);
        $user->img = $imgName;

    }

    // Lưu thay đổi vào database
    $user->save();

    // Lưu thay đổi

    return response()->json([
        'message' => 'User information updated successfully',
        'user' => $user,
    ]);
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
