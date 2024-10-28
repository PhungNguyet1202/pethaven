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
        'imgdetail',
        'categories_id',
    ];

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'service_id'); // Chỉ định khóa ngoại là service_id
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
