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
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('shoppingcart_id');
           $table->unsignedBigInteger('shoppingcart_id'); // Foreign key to ShoppingCart
            $table->unsignedBigInteger('product_id');      // Foreign key to Products
            $table->integer('quantity');                  // Number of items in the cart
            $table->decimal('price', 8, 2);               // Price of the product
            $table->decimal('total_price', 8, 2);         // Total price for this item (quantity * price)
            $table->timestamps();                         // created_at and updated_at
        
            // Foreign key constraints
            // $table->foreign('shoppingcart_id')->references('shoppingcart');
            // $table->foreign('product_id')->references('products');
           // $table->foreign('shoppingcart_id')->references('id')->on('shoppingcart')->onDelete('cascade');  
        //    $table->foreign('shoppingcart_id')->references('id')->on('shoppingcart') ->onDelete('cascade');
        $table->foreign('shoppingcart_id')->references('id')->on('shoppingcarts')->onDelete('cascade');

           $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');  

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
