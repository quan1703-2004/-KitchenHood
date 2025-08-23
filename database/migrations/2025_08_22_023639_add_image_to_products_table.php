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
        Schema::table('products', function (Blueprint $table) {
            // Thêm trường hình ảnh
            $table->string('image')->nullable()->after('description');
            
            // Cập nhật trường quantity để có giá trị mặc định
            $table->integer('quantity')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa trường hình ảnh
            $table->dropColumn('image');
            
            // Khôi phục trường quantity
            $table->integer('quantity')->change();
        });
    }
};
