<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Chỉ cần một lần `use Notifiable`

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // Thêm thuộc tính phone
        'address' // Thêm thuộc tính address
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        //'password' => 'hashed',
    ];

    // Định nghĩa các quan hệ với các model khác
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'user_id');
    }

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


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