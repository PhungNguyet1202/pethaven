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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // Tên dịch vụ
            $table->string('description');         // Mô tả dịch vụ
            $table->decimal('price', 8, 2);        // Giá dịch vụ
            $table->string('img')->nullable();     // Hình ảnh dịch vụ (nếu có)
            $table->timestamps();

            // Tạo khóa ngoại liên kết với bảng categories
            $table->foreignId('categories_id')
                  ->constrained('categories')
                  ->onDelete('cascade');           // Xóa service khi xóa category
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
