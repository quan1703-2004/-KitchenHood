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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']); // in: nhập hàng, out: xuất hàng
            $table->integer('quantity'); // Số lượng nhập/xuất
            $table->integer('quantity_before'); // Số lượng trước khi thay đổi
            $table->integer('quantity_after'); // Số lượng sau khi thay đổi
            $table->text('notes')->nullable(); // Ghi chú
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Người thực hiện
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Liên kết với đơn hàng (nếu xuất hàng)
            $table->timestamps();
            
            // Index để tối ưu truy vấn
            $table->index(['product_id', 'type']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
