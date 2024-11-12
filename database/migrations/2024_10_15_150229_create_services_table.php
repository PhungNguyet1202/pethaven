<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);               
            $table->string('description');         
            $table->decimal('price', 10, 2);       
            $table->string('img',255);     
            $table->string('imgdetail',255);    
            $table->timestamps();

            $table->foreignId('categories_id')->constrained('categories')->onDelete('cascade');          
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
