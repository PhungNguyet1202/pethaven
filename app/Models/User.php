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
        'phone',
        'address',
        'google_id',
        'img', // Thêm vào đây để có thể cập nhật ảnh đại diện
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
        return $this->hasMany(ServiceBooking::class, 'user_id'); // Chỉ định khóa ngoại là user_id
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'pets_id');
    }

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class, 'shoppingcart_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'review_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'new_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }









}
