<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'categorynew_id', 'image', 'description', 'description2'];

    // Một tin tức thuộc về một loại tin tức (categorynew)
    public function categorynew()
    {
        return $this->belongsTo(Categorynew::class);
    }

    // Một tin tức thuộc về một người dùng (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}