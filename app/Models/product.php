<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'price',

        'sale_price',
        'image',
    ];

    // Quan hệ giữa Product và Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }   

    // Quan hệ giữa Product và Review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

       // Quan hệ giữa Product và CartItem
       public function cartItems()
       {
           return $this->hasMany(CartItem::class, 'product_id');
       }


    /**
     * Lấy các StockIn thuộc về Product này.
     */
    public function stockIns() {
        return $this->hasMany(Stockin::class, 'product_id'); // Sửa tên class thành Stockin
    }
    // Quan hệ giữa Product và StockIn
    // public function stockIns()
    // {
    //     return $this->hasMany(Stockin::class, 'product_id'); // Đảm bảo tên class là Stockin

    // }

    // Quan hệ giữa Product và Inventory
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    // Quan hệ giữa Product và OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orderdetail_id');
    }

    // Quan hệ giữa Product và Comment
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }
}