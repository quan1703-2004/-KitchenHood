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
            $table->string('title'); // Tiêu đề tin tức
            $table->string('slug')->unique(); // URL slug
            $table->text('excerpt'); // Tóm tắt ngắn
            $table->longText('content'); // Nội dung đầy đủ
            $table->string('image')->nullable(); // Hình ảnh
            $table->string('category'); // Danh mục (xu hướng, hướng dẫn, khuyến mãi, công nghệ)
            $table->string('author')->default('Admin'); // Tác giả
            $table->boolean('is_featured')->default(false); // Tin nổi bật
            $table->boolean('is_published')->default(true); // Trạng thái xuất bản
            $table->integer('views')->default(0); // Lượt xem
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
