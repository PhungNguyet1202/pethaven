<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'description', 'image', 'detail', 'categorynew_id', 'user_id'
    ];

    // Liên kết tới CategoryNew
    public function categorynew()
    {
        return $this->belongsTo(CategoryNew::class);
    }

    // Liên kết tới User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
