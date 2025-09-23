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
        // Tạo bảng questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ai hỏi (customer)
            $table->string('title'); // tiêu đề câu hỏi
            $table->string('category')->default('general'); // danh mục câu hỏi
            $table->text('content'); // nội dung câu hỏi
            $table->tinyInteger('is_answered')->default(0); // 0 = chưa trả lời, 1 = đã trả lời
            $table->timestamps();
        });

        // Tạo bảng answers
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id'); // ID câu hỏi
            $table->unsignedBigInteger('user_id'); // ai trả lời (admin hoặc user)
            $table->text('content'); // nội dung trả lời
            $table->timestamps();
        });

        // Chỉ thêm khóa ngoại tới users sau khi bảng users tồn tại
        if (Schema::hasTable('users')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            Schema::table('answers', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Khóa ngoại nội bộ giữa answers -> questions có thể tạo ngay
        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
    }
};
