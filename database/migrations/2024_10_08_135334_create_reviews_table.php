<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();           
            $table->integer('Rating');            
            $table->text('Comment')->nullable();    
            $table->unsignedBigInteger('product_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->timestamps();                   

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
