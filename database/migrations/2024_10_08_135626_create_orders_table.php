<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('user_fullname',255);
        $table->string('user_email',255);
        $table->string('user_phone',255);
        $table->string('user_address',255);
        $table->enum('status',['pending','prepare','shipping','success','cancle'])->default('pending');
        $table->decimal('total_money',10,2);
        $table->unsignedBigInteger('user_id')->nullable();
        $table->unsignedBigInteger('payment_id')->nullable(); 
        $table->unsignedBigInteger('shipping_id')->nullable(); 
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('cascade');
    });
    }
  
    public function down(): void
    {
       
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->dropColumn('product_id'); 
        });
    }
};
