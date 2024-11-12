<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->string('name',255); 
            $table->string('slug',255);
            $table->string('image',255); 
            $table->text('description');
            $table->decimal('price', 10, 2); 
            $table->decimal('sale_price', 10, 2); 
            $table->integer('instock')->nullable();
            $table->integer('inventory')->nullable();
            $table->float('rating')->default(0); 
            //$table->boolean('status')->default(1); // Trạng thái sản phẩm (1: có sẵn, 0: ngừng bán)
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps(); 
     
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};