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
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột shipping_ward_code để lưu mã phường/xã cho GHN API
            $table->string('shipping_ward_code')->nullable()->after('shipping_ward_name');
            
            // Thêm index để tối ưu query
            $table->index('shipping_ward_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['shipping_ward_code']);
            $table->dropColumn('shipping_ward_code');
        });
    }
};