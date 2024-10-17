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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Tạo cột id
            $table->string('name',100); // Tạo cột name
            $table->string('slug',255);
            $table->text('description')->nullable(); // Tạo cột description, cho phép null
            $table->timestamps(); // Tạo cột created_at và updated_at
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
