<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id(); 
            $table->date('shipping_date');            
            $table->string('shipping_method',255);         
            $table->string('shipping_address',255);       
            $table->string('shipping_status',255);         
            $table->timestamps();                     
            
  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
