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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động tăng
            $table->string('name',255); // Tên sản phẩm
            $table->string('slug',255);
            $table->string('image',255); // Đường dẫn hình ảnh
            $table->text('description'); // Mô tả sản phẩm

           // $table->integer('quantity'); // Số lượng sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->decimal('sale_price', 10, 2); // Giá sản phẩm
            //$table->string('sku')->unique(); // Mã SKU, phải là duy nhất
            $table->integer('instock');// so luong ton kho
            $table->float('rating')->default(0); // danh gia
            //$table->boolean('status')->default(1); // Trạng thái sản phẩm (1: có sẵn, 0: ngừng bán)
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            
            //$table->foreignId('categories_id')->constrained('categories')->onDelete('cascade'); // Khóa ngoại đến bảng categories
            $table->timestamps(); // Timestamps cho created_at và updated_at
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};