<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth; // Nếu bạn sử dụng JWT


class AuthTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken(); // Lấy token từ header Authorization
    
        $token = $request->bearerToken();
        if ($token && JWTAuth::setToken($token)->check()) {
            return $next($request);
        }
        
    
        return response()->json(['error' => 'Unauthorized'], 401); // Trả về lỗi nếu token không hợp lệ
    }
}    