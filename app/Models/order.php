<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model // Đổi tên lớp thành `Order` (viết hoa) theo quy tắc PSR-1
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_money',

        'status',
        'created_at',
        'payment_id',
        'shipping_id',
        'user_fullname',
        'user_address',
        'user_phone',
        'user_email'
    ];


    /**
     * Lấy Customer mà Order thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }


    /**
     * Lấy các Shipping thuộc về Order này.
     */
    public function shippings()
    {

        return $this->hasOne(Shipping::class, 'id'); // Giả sử 'id' là khóa chính trong bảng Shipping


    }

    /**
     * Lấy các Payment thuộc về Order này.
     */
    public function payments()
    {

        return $this->hasOne(Payment::class, 'id'); // Giả sử 'id' là khóa chính trong bảng Payment

    }
}
