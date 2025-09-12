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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'qr_code', 'momo'
            $table->string('name'); // 'QR Code Ngân hàng', 'Momo'
            $table->text('description')->nullable();
            $table->string('qr_code_image')->nullable(); // Đường dẫn ảnh QR code
            $table->string('bank_name')->nullable(); // Tên ngân hàng
            $table->string('account_number')->nullable(); // Số tài khoản
            $table->string('account_name')->nullable(); // Tên chủ tài khoản
            $table->string('momo_phone')->nullable(); // Số điện thoại Momo
            $table->string('momo_name')->nullable(); // Tên chủ tài khoản Momo
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
