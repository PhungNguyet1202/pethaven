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
            $table->rememberToken();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable(); // Date of birth
            $table->string('img')->nullable(); // Profile image
            $table->boolean('is_action')->default(0); // 0: Active, 1: Blocked
            $table->timestamps();
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->string('phone');
        //     $table->string('address');
        //     $table->string('password');
        //     $table->enum('role', ['admin', 'user'])->default('user');
        //     $table->rememberToken();
        //     $table->enum('gender', ['male', 'female', 'other'])->nullable(); 
        //     $table->date('dob')->nullable(); // Tạo cột ngày sinh
        //     $table->string('img')->nullable(); // 
        //     $table->boolean('is_action',['0', '1'])->default('0'); // 0: Hoạt động, 1: Bị khóa
        //     $table->timestamps();
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
