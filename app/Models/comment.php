<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

        // Các thuộc tính và phương thức khác...
    
        /**
         * Lấy người dùng sở hữu bình luận.
         */
        public function user()
        {
            return $this->belongsTo(User::class);
        }
    
        /**
         * Lấy sản phẩm sở hữu bình luận.
         */
        public function product()
        {
            return $this->belongsTo(Product::class);
        }
    
}
