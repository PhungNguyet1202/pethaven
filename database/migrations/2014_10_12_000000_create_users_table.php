<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->string('phone');
            $table->string('address',255);
            $table->string('password',255);
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken(); 
            $table->enum('gender', ['male', 'female', 'other'])->nullable();   
            $table->date('dob')->nullable(); 
            $table->string('img')->nullable(); 
            $table->date('birthday_date')->nullable(); 
            $table->boolean('is_action')->default(0); // 0: Active, 1: Blocked
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};