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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
           // $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_fullname');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_address');
            $table->enum('status',['pending','prepare','shipping','success','cancle'])->default('pending');
            $table->integer('total_money')->default(0);
            $table->integer('total_quantity')->default(0);
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
 // Foreign keys
            $table->unsignedBigInteger('user_id'); // Foreign key for customer
            $table->unsignedBigInteger('payment_id'); // Foreign key for payment
            $table->unsignedBigInteger('shipping_id'); // Foreign key for shipping

           // $table->timestamps(); // Timestamps

            // Define foreign keys with correct references
            $table->foreign('user_id')
                  ->references('id') // Column in the referenced table
                  ->on('users')   // Referenced table
                  ->onDelete('cascade');

            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('cascade');

            $table->foreign('shipping_id')
                  ->references('id')
                  ->on('shippings') // Ensure this matches your actual table name
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
