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
        // Nếu bảng đã tồn tại (vd: đã tạo thủ công), bỏ qua tạo mới để tránh lỗi
        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->text('question'); // Nội dung câu hỏi
                $table->longText('answer'); // Nội dung câu trả lời
                $table->boolean('is_visible')->default(true); // Bật/tắt hiển thị ngoài trang chủ
                $table->integer('sort_order')->default(0); // Thứ tự sắp xếp
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
