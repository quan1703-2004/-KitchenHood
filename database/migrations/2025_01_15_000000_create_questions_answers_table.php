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
        // Chỉ chạy khi bảng questions đã tồn tại để tránh lỗi khi migrate fresh từ đầu
        if (Schema::hasTable('questions')) {
            Schema::table('questions', function (Blueprint $table) {
                // Kiểm tra xem cột category đã tồn tại chưa
                if (!Schema::hasColumn('questions', 'category')) {
                    $table->string('category')->default('general')->after('title');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('questions')) {
            Schema::table('questions', function (Blueprint $table) {
                if (Schema::hasColumn('questions', 'category')) {
                    $table->dropColumn('category');
                }
            });
        }
    }
};