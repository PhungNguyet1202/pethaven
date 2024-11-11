<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method',255); 
            $table->string('payment_status',255); 
            $table->dateTime('payment_date'); 
            $table->string('transaction_id',255); 
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
