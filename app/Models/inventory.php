<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory'; // Đảm bảo tên bảng là 'inventory'

    protected $fillable = [
        'product_id',
        'quantity_instock',
        'stockin_id',

    ];

    public $timestamps = true; // Nếu bảng của bạn có các trường `created_at` và `updated_at`

    protected $dates = [
        'last_update', // Nếu muốn Laravel tự động quản lý định dạng cho `last_update`
    ];

    // Định nghĩa quan hệ với bảng Products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Định nghĩa quan hệ với bảng StockIn
    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stockin_id');
    }
}
