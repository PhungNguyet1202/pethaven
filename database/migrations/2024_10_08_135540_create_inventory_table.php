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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động tăng
            $table->integer('quantity_instock'); // Cột quantity_instock
            $table->timestamp('last_update')->nullable(); // Cột last_update, có thể null
          //  $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Khóa ngoại cho productID
           // $table->foreignId('stockin_id')->constrained('stockin')->onDelete('cascade'); // Khóa ngoại cho stockinID
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stockin_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->foreign('stockin_id')->references('id')->on('stockin')->onDelete('cascade');  
            $table->timestamps(); // Tạo cột created_at và updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
