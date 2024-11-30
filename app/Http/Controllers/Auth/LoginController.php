<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginController extends Controller
{
    // Đăng nhập bằng Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            // Kiểm tra xem người dùng đã tồn tại chưa
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                $token = $findUser->createToken('GoogleAuthToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập Google thành công',
                    'user' => $findUser,
                    'access_token' => $token,
                ], 200);
            } else {
                // Tạo người dùng mới nếu không tìm thấy
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy'), // Mật khẩu dummy
                ]);

                Auth::login($newUser);
                $token = $newUser->createToken('GoogleAuthToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Đăng ký và đăng nhập Google thành công',
                    'user' => $newUser,
                    'access_token' => $token,
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xử lý đăng nhập Google',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
