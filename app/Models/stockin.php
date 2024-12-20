<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockin extends Model
{
    use HasFactory;

    /**
     * Lấy Customer mà ShoppingCart thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'shoppingcart_id');
    }
}
