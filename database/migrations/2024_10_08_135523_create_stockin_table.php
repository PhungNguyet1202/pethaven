<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('stockin', function (Blueprint $table) {
            $table->id();          
            $table->date('stockin_date');            
            $table->integer('Quantity');   
            $table->unsignedBigInteger('product_id');          
            $table->timestamps();                 
        
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');  

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('stockin');
    }
};
