<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockin extends Model // Sửa tên class thành Stockin
{
    use HasFactory;

    protected $table = 'stockin'; // Chỉ định tên bảng (nếu cần thiết)

    /**
     * Lấy User mà Stockin thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cartitem_id');
    }
}