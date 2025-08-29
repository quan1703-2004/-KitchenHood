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
            // Thêm các cột mới nếu chưa tồn tại
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->bigInteger('subtotal')->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->bigInteger('discount_amount')->default(0)->after('shipping_fee');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('payment_method');
            }
            
            // Thêm các cột cho thông tin giao hàng
            if (!Schema::hasColumn('orders', 'shipping_name')) {
                $table->string('shipping_name')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'shipping_phone')) {
                $table->string('shipping_phone')->nullable()->after('shipping_name');
            }
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('shipping_phone');
            }
            if (!Schema::hasColumn('orders', 'shipping_province_id')) {
                $table->integer('shipping_province_id')->nullable()->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'shipping_province_name')) {
                $table->string('shipping_province_name')->nullable()->after('shipping_province_id');
            }
            if (!Schema::hasColumn('orders', 'shipping_district_id')) {
                $table->integer('shipping_district_id')->nullable()->after('shipping_province_name');
            }
            if (!Schema::hasColumn('orders', 'shipping_district_name')) {
                $table->string('shipping_district_name')->nullable()->after('shipping_district_id');
            }
            if (!Schema::hasColumn('orders', 'shipping_ward_id')) {
                $table->integer('shipping_ward_id')->nullable()->after('shipping_district_name');
            }
            if (!Schema::hasColumn('orders', 'shipping_ward_name')) {
                $table->string('shipping_ward_name')->nullable()->after('shipping_ward_id');
            }
            
            // Thêm các cột cho đánh giá
            if (!Schema::hasColumn('orders', 'rating')) {
                $table->integer('rating')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'review_comment')) {
                $table->text('review_comment')->nullable()->after('rating');
            }
            if (!Schema::hasColumn('orders', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('review_comment');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa các cột mới
            $columns = [
                'user_id', 'subtotal', 'discount_amount', 'payment_status',
                'shipping_name', 'shipping_phone', 'shipping_address',
                'shipping_province_id', 'shipping_province_name',
                'shipping_district_id', 'shipping_district_name',
                'shipping_ward_id', 'shipping_ward_name',
                'rating', 'review_comment', 'reviewed_at'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
