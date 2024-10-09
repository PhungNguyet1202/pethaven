<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Lấy các CartItem thuộc về Product này.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    /**
     * Lấy các StockIn thuộc về Product này.
     */
    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'product_id');
    }

    /**
     * Lấy các Inventory thuộc về Product này.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    /**
     * Lấy các OrderDetail thuộc về Product này.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
