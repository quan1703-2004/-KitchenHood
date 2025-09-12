<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cập nhật enum cho payment_method để thêm 'momo'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer', 'momo') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khôi phục enum cũ
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer') NOT NULL");
    }
};
