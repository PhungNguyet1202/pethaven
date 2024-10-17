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
            // Validate input
            $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:15',
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
    
            // Redirect to login page with success message
            return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }
    


    public function postlogin(Request $req) {
        // Validate input
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        // Attempt to log in
        if (Auth::attempt(['email' => $req->input('email'), 'password' => $req->input('password')])) {
            // Redirect to homepage with success message
            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        }
    
        // If login fails, return back with error message
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!'])->withInput();
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
