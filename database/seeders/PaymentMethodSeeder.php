<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo phương thức QR Code
        PaymentMethod::create([
            'type' => 'qr_code',
            'name' => 'QR Code Vietcombank',
            'description' => 'Thanh toán qua QR Code ngân hàng Vietcombank',
            'bank_name' => 'Vietcombank',
            'account_number' => '1234567890',
            'account_name' => 'NGUYEN VAN A',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Tạo phương thức Momo
        PaymentMethod::create([
            'type' => 'momo',
            'name' => 'Ví điện tử Momo',
            'description' => 'Thanh toán qua ví điện tử Momo',
            'momo_phone' => '0901234567',
            'momo_name' => 'NGUYEN VAN A',
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
