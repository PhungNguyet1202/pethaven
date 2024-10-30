<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    // protected $table = 'servicebooking'; // Chỉ định tên bảng nếu không theo quy tắc số nhiều
    // protected $fillable = [
    //         'user_id',
    //         'pet_id',
    //         'service_id',
    //         'booking_date',
    //         'phone',
    //         'email',
    //     ];
    
    protected $table = 'servicebookings'; // Tên bảng phải trùng khớp
    protected $fillable = [
        'user_id',
        'pet_id',
        'service_id',
        'booking_date',
        'status',
        'total_price',
        'phone', // nếu bạn có trường này
        'email'  // nếu bạn có trường này
    ];
    /**
     * Lấy Customer mà ServiceBooking thuộc về.
     */
    public function user()
    {

        // return $this->belongsTo(User::class, 'user_id'); // Kết nối với bảng customers thông qua user_id

        return $this->belongsTo(User::class, 'user_id');

    }

    /**
     * Lấy Pet mà ServiceBooking thuộc về.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id'); // Kết nối với bảng pets thông qua pet_id
    }

    /**
     * Lấy Service mà ServiceBooking thuộc về.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id'); // Kết nối với bảng services thông qua service_id
    }
}
