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
        'slug',

    ];



    /**
     * Lấy các Product thuộc về Category này.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
