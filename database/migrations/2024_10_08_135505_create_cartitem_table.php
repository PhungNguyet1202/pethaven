<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shoppingcart_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            $table->foreign('shoppingcart_id')->references('id')->on('shoppingcarts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
