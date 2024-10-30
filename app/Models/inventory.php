<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory'; // Đảm bảo tên bảng là 'inventory'
    protected $fillable = [
        'product_id', // Thêm vào đây
        'quantity_instock', // Các thuộc tính khác bạn muốn cho phép
        'stockin_id',
        // ... thêm các thuộc tính khác nếu cần
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stockin_id');
    }
}