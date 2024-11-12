<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderdetail'; // Chỉ định tên bảng chính xác là `orderdetail`

    // Thêm các cột vào mảng fillable để cho phép mass assignment
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
