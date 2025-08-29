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
        Schema::table('addresses', function (Blueprint $table) {
            // Xóa các cột cũ
            $table->dropColumn(['province', 'district', 'ward']);
            
            // Thêm các cột mới cho API tỉnh thành
            $table->integer('province_id')->after('phone');
            $table->string('province_name')->after('province_id');
            $table->integer('district_id')->after('province_name');
            $table->string('district_name')->after('district_id');
            $table->integer('ward_id')->after('district_name');
            $table->string('ward_name')->after('ward_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Xóa các cột mới
            $table->dropColumn(['province_id', 'province_name', 'district_id', 'district_name', 'ward_id', 'ward_name']);
            
            // Thêm lại các cột cũ
            $table->string('province')->after('phone');
            $table->string('district')->after('province');
            $table->string('ward')->after('district');
        });
    }
};
