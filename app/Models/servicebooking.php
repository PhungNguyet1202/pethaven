<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicebooking extends Model
{
    use HasFactory;

    /**
     * Lấy Customer mà ServiceBooking thuộc về.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   

    /**
     * Lấy Pet mà ServiceBooking thuộc về.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
