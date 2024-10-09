<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    
    public function login(){
        return view('user.login'); 
    }

  
    public function register(){
        return view('user.register'); 
    }

    public function postregister(Request $req){
        $email = $req->input('email');
        $password =$req->input('password') ;
        $repassword =  $req->input('repassword');
        $name = $req->input('name');
        $phone = $req->input('phone');
        $address = $req->input('address');
  
        if($password!=$repassword){
           session()->put('message','Mật khẩu nhập lại không trùng khớp!');
           return back();
        }
  
        $user = User::where('email',$email)->first();
        if(isset($user)){
           session()->put('message','Email đã tồn tại! Không thể đăng ký');
           return back();
        }
  
        $user = new User();
        $user->name = $name;
         $user->password = $password;
//$user->password = Hash::make($password);
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;
        $user->save();
        return redirect()->route('login'); // dang ky thanh cong se chuy qua trang dang nhap
  
  
  
     }
     public function postlogin(Request $req){
        $email = $req->input('email');
        $password = $req->input('password');
        // $remember= $req->input('remember');
  
        $user = User::where('email', $email)->first();
        $canLogin= false;
        if(isset($user)){
         $canLogin= Hash::check($password, $user->password);
        }
        if($canLogin){// cho phap dang nhap
          Auth::login($user);
        // Auth::guard('customer')->login($user); 
           return redirect()->route('home');
        //    ,$remember
        }else{
           session()->put('message','Email hoặc mật khẩu không đúng!');
           return back();
        }
     }

// public function postregister(Request $req) {
//    $email = $req->input('email');
//    $password = $req->input('password');
//    $repassword = $req->input('repassword');
//    $name = $req->input('name');
//    $phone = $req->input('phone');
//    $address = $req->input('address');

//    if ($password != $repassword) {
//        session()->put('message', 'Mật khẩu nhập lại không trùng khớp!');
//        return back();
//    }

//    $user = Customer::where('email', $email)->first();
//    if (isset($user)) {
//        session()->put('message', 'Email đã tồn tại! Không thể đăng ký');
//        return back();
//    }

//    // Hash the password using Bcrypt before saving
//    $user = new Customer();
//    $user->name = $name;
//    $user->password = Hash::make($password); // Hash the password with Bcrypt
//    $user->email = $email;
//    $user->phone = $phone;
//    $user->address = $address;
//    $user->save();

//    return redirect()->route('login');
// }
// public function postlogin(Request $req) {
//    $email = $req->input('email');
//    $password = $req->input('password');

//    $user = Customer::where('email', $email)->first();
//    $canLogin = false;

//    if (isset($user)) {
//        // Check if the password is already Bcrypt-hashed
//        if (strlen($user->password) === 60 && substr($user->password, 0, 4) === '$2y$') {
//            // Use Bcrypt for comparison
//            $canLogin = Hash::check($password, $user->password);
//        } else {
//            // For plaintext or other non-Bcrypt passwords, compare directly
//            if ($password === $user->password) {
//                $canLogin = true;

//                // Rehash the password using Bcrypt and save it to the database
//                $user->password = Hash::make($password);
//                $user->save();
//            }
//        }
//    }

//    if ($canLogin) {
//        Auth::login($user);
//        return redirect()->route('home');
//    } else {
//        session()->put('message', 'Email hoặc mật khẩu không đúng!');
//        return back();
//    }
// }

}