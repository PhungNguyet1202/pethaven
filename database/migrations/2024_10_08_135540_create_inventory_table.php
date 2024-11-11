<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id(); 
            $table->integer('quantity_instock'); 
            // $table->timestamp('last_update')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stockin_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->foreign('stockin_id')->references('id')->on('stockin')->onDelete('cascade');  
            $table->timestamps();

        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
