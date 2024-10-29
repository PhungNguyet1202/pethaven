<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pet extends Model
{
    use HasFactory;

    /**
     * Lấy Customer mà Pet thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  

    /**
     * Lấy các ServiceBooking của Pet.
     */
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'pet_id'); // Chỉ định khóa ngoại là pet_id
    }
    
}
