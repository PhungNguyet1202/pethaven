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
        Schema::create('stockin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Foreign key to Products
            $table->date('stockin_date');            // Date the stock was added
            $table->integer('Quantity');             // Quantity of items added to stock
            $table->timestamps();                    // created_at and updated_at
        
            // Foreign key constraints
            // $table->foreign('product_id')->references('products');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');  

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockin');
    }
};
