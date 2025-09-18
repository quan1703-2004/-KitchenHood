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
        // Cập nhật enum cho payment_method để bỏ 'qr_code'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer', 'momo') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khôi phục enum có 'qr_code'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cod', 'bank_transfer', 'momo', 'qr_code') NOT NULL");
    }
};