<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cartitem extends Model
{
    use HasFactory;
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
    public function shoppingCart()
    {
        return $this->belongsTo(ShoppingCart::class, 'shoppingcart_id');
    }

    protected $fillable = ['shoppingcart_id', 'product_id', 'quantity', 'price', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
