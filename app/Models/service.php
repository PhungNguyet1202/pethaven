<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model 
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'img',
         
    ];

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'service_id'); // Chỉ định khóa ngoại là service_id
    }
    

  
}