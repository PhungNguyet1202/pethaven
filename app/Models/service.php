<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'service_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
