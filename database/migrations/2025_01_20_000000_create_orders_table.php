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
            $table->string('order_number')->unique(); // Mã đơn hàng
            $table->string('customer_name'); // Tên khách hàng
            $table->string('customer_email'); // Email khách hàng
            $table->string('customer_phone'); // Số điện thoại
            $table->text('customer_address'); // Địa chỉ giao hàng
            $table->enum('payment_method', ['cod', 'bank_transfer', 'momo']); // Phương thức thanh toán
            $table->text('notes')->nullable(); // Ghi chú
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending'); // Trạng thái đơn hàng
            $table->bigInteger('total_amount'); // Tổng tiền sản phẩm
            $table->bigInteger('shipping_fee'); // Phí vận chuyển
            $table->bigInteger('final_amount'); // Tổng tiền cuối cùng
            $table->timestamps();
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
