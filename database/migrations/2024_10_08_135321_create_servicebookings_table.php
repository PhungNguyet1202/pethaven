<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
       
        Schema::create('servicebookings', function (Blueprint $table) {
            $table->id(); 
            $table->date('booking_date');  
            $table->time('booking_time'); 
            $table->string('status',255);  
            $table->decimal('total_price', 10, 2);  
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->unsignedBigInteger('pet_id'); 
            $table->unsignedBigInteger('service_id'); 
            $table->string('phone')->nullable(); 
            $table->string('email')->nullable(); 
            $table->timestamps();
        });
        
          
    }

   
    public function down(): void
    {
        Schema::dropIfExists('servicebookings');
    }
};
