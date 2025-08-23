<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Tên người dùng
            $table->string('email')->unique(); // Email (duy nhất)
            $table->string('password');       // Mật khẩu
            $table->enum('role', ['admin', 'customer'])->default('customer'); // Vai trò
            $table->rememberToken();          // Token ghi nhớ đăng nhập
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};