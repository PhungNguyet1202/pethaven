<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockin extends Model // Sửa tên class thành Stockin
{
    use HasFactory;

    protected $table = 'stockin'; // Chỉ định tên bảsng (nếu cần thiết)

    // Thêm thuộc tính fillable
    protected $fillable = [
        'product_id', // Thêm vào đây
        'Quantity', // Nếu có
        'stockin_date', // Nếu có
    ];

    /**
     * Lấy User mà Stockin thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}