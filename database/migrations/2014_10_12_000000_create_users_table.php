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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken()->nullable(); // rememberToken có thể null
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Gender có thể null     
            $table->date('dob')->nullable(); // Date of birth có thể null
            $table->string('img')->nullable(); // Profile image có thể null
            $table->boolean('is_action')->default(0); // 0: Active, 1: Blocked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};