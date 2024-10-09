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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tựa đề tin tức
            $table->text('content'); // Nội dung tin tức
            $table->text('description'); // Mô tả sản phẩm
            $table->string('image',255); // Đường dẫn hình ảnh
            $table->string('detail')->nullable(); // Đường dẫn hình ảnh

            $table->foreignId('categorynew_id')->constrained()->onDelete('cascade'); // Khóa ngoại tới bảng categorynew
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại tới bảng users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
