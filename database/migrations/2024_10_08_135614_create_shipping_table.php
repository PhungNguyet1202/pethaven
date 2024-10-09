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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();                  // Primary Key
            //  $table->unsignedBigInteger('order_id');     // Foreign key to Orders
              $table->date('shipping_date');             // Date when the order was shipped
              $table->string('shipping_method');         // Method used for shipping
              $table->string('shipping_address');        // Address where the order is being shipped
              $table->string('shipping_status');         // Current status of the shipping
              $table->timestamps();                      // created_at and updated_at
          
              // Foreign key constraints
              // $table->foreign('order_id')->references('orders');
            //  $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); 
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
