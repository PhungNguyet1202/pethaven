<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Lấy người dùng (customer) mà review này thuộc về.
     */
  // Trong app/Models/Review.php
public function user()
{
    return $this->belongsTo(User::class);
}

    /**
     * Lấy sản phẩm mà review này thuộc về.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
