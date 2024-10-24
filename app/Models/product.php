<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'review_id');
    }

    /**
     * Lấy các CartItem thuộc về Product này.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cartitem_id');
    }

    /**
     * Lấy các StockIn thuộc về Product này.
     */
    public function stockIns() {
        return $this->hasMany(Stockin::class, 'stockin_id'); // Sửa tên class thành Stockin
    }
    

    /**
     * Lấy các Inventory thuộc về Product này.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'inventory_id');
    }

    /**
     * Lấy các OrderDetail thuộc về Product này.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orderdetail_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

}