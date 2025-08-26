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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // ID đơn hàng
            // Không đặt ràng buộc khóa ngoại tới products để tránh lỗi thứ tự migration
            $table->unsignedBigInteger('product_id'); // ID sản phẩm
            $table->index('product_id');
            $table->string('product_name'); // Tên sản phẩm (lưu để tránh thay đổi)
            $table->bigInteger('product_price'); // Giá sản phẩm (lưu để tránh thay đổi)
            $table->integer('quantity'); // Số lượng
            $table->bigInteger('subtotal'); // Thành tiền
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
