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
        Schema::table('order_history', function (Blueprint $table) {
            // Thêm các cột cần thiết cho order history
            $table->unsignedBigInteger('order_id')->after('id');
            $table->string('status')->after('order_id');
            $table->text('note')->nullable()->after('status');
            $table->string('created_by')->default('system')->after('note');
            
            // Thêm foreign key constraint
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            
            // Thêm index để tối ưu query
            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropIndex(['order_id', 'created_at']);
            $table->dropColumn(['order_id', 'status', 'note', 'created_by']);
        });
    }
};