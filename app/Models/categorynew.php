<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorynew extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Một loại tin tức có nhiều tin tức
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
