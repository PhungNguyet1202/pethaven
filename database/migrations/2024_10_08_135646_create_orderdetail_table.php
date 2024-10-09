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
        Schema::create('orderdetail', function (Blueprint $table) {
            $table->id();               // Primary Key
            $table->unsignedBigInteger('order_id');     // Foreign key to Orders
            $table->unsignedBigInteger('product_id');   // Foreign key to Products
            $table->decimal('price', 8, 2);            // Price of the product in the order
            $table->integer('quantity');               // Quantity of the product in the order
            $table->timestamps();                      // created_at and updated_at
        
            // Foreign key constraints
            // $table->foreign('order_id')->references('orders');
            // $table->foreign('product_id')->references('products');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdetail');
    }
};
