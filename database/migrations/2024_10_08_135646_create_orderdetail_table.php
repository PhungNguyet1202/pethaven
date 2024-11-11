<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('orderdetail', function (Blueprint $table) {
            $table->id();             
            $table->unsignedBigInteger('order_id');     
            $table->unsignedBigInteger('product_id'); 
            $table->decimal('price', 10, 2);           
            $table->integer('quantity');      
            $table->decimal('total_price', 10, 2);    
            $table->timestamps();                     
        
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); 

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('orderdetail');
    }
};
