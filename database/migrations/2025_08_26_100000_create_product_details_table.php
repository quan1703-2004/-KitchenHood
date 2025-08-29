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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // Cặp key/value linh hoạt cho chi tiết, dùng JSON để dễ mở rộng theo todo-list
            $table->json('specs')->nullable(); // ví dụ: [{key:"Công suất hút", value:"600 m3/h"}, ...]
            $table->timestamps();
        });

        // Thêm cột ảnh phụ cho bảng products để hỗ trợ tối đa 3 ảnh
        Schema::table('products', function (Blueprint $table) {
            $table->string('image2')->nullable()->after('image');
            $table->string('image3')->nullable()->after('image2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image2', 'image3']);
        });
        Schema::dropIfExists('product_details');
    }
};


