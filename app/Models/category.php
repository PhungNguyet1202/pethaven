<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name',
        'description',

    ];
    
    public function services()
    {
        return $this->hasMany(Service::class, 'service_id');
    }

    /**
     * Lấy các Product thuộc về Category này.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
