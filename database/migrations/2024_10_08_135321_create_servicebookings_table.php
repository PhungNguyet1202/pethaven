<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicebookings', function (Blueprint $table) {
            $table->id();  // id tự động tăng
            $table->date('booking_date');  // Ngày đặt
            $table->string('status');  // Trạng thái của booking
            $table->decimal('total_pirce', 8, 2);  // Tổng số tiền (ví dụ định dạng tiền tệ)

            // Các khóa ngoại
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('service_id');

            // Thiết lập khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade'); 
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');        
            // $table->foreign('customer_id')->references('customers')->onDelete('cascade');
            // $table->foreign('pet_id')->references('pets')->onDelete('cascade');
            // $table->foreign('service
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicebookings');
    }
};
