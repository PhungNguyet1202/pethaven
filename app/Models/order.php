<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

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
        return $this->hasMany(Shipping::class, 'order_id');
    }

    /**
     * Lấy các Payment thuộc về Order này.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }
}