<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // liên kết 1 đánh giá với 1 lần mua cụ thể (order_item)
            $table->foreignId('order_item_id')->nullable()->after('product_id')->constrained('order_items')->nullOnDelete();
            // phản hồi của admin
            $table->text('admin_reply')->nullable()->after('comment');
            $table->timestamp('admin_replied_at')->nullable()->after('admin_reply');
        });

        // unique để 1 order_item chỉ có tối đa 1 review
        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['order_item_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique(['order_item_id']);
            if (Schema::hasColumn('reviews', 'order_item_id')) {
                $table->dropConstrainedForeignId('order_item_id');
            }
            if (Schema::hasColumn('reviews', 'admin_reply')) {
                $table->dropColumn('admin_reply');
            }
            if (Schema::hasColumn('reviews', 'admin_replied_at')) {
                $table->dropColumn('admin_replied_at');
            }
        });
    }
};


