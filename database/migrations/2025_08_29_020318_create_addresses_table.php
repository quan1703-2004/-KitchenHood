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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa phụ đến users
            $table->string('full_name'); // Họ tên người nhận
            $table->string('phone'); // Số điện thoại
            $table->string('province'); // Tỉnh/Thành phố
            $table->string('district'); // Quận/Huyện
            $table->string('ward'); // Phường/Xã
            $table->text('street_address'); // Địa chỉ chi tiết (số nhà, tên đường)
            $table->string('postal_code')->nullable(); // Mã bưu điện (có thể để trống)
            $table->boolean('is_default')->default(false); // Địa chỉ mặc định
            $table->text('note')->nullable(); // Ghi chú thêm
            $table->timestamps();
            
            // Thêm index để tối ưu truy vấn
            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
