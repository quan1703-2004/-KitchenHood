<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class CreateTestOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:create-test-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo đơn hàng test để kiểm tra GHN sync';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🛒 Tạo đơn hàng test cho GHN...");
        
        try {
            // Tìm user đầu tiên hoặc tạo user test
            $user = User::first();
            if (!$user) {
                $this->error("❌ Không có user nào trong hệ thống");
                return;
            }
            
            // Tạo đơn hàng test với mã GHN giả
            $testOrderCode = 'TEST' . date('YmdHis') . rand(100, 999);
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . date('YmdHis'),
                'order_code' => $testOrderCode, // Mã GHN test
                'status' => 'pending',
                'subtotal' => 500000,
                'shipping_fee' => 30000,
                'discount_amount' => 0,
                'total_amount' => 530000,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'shipping_name' => 'Nguyễn Văn Test',
                'shipping_phone' => '0123456789',
                'shipping_address' => '123 Đường Test, Phường Test',
                'shipping_province_id' => 202,
                'shipping_province_name' => 'Hồ Chí Minh',
                'shipping_district_id' => 1542,
                'shipping_district_name' => 'Quận 1',
                'shipping_ward_id' => 20101,
                'shipping_ward_name' => 'Phường Bến Nghé',
                'shipping_ward_code' => '20101',
                'notes' => 'Đơn hàng test cho GHN sync'
            ]);
            
            $this->info("✅ Đã tạo đơn hàng test:");
            $this->line("   📋 Order ID: {$order->id}");
            $this->line("   📋 Order Number: {$order->order_number}");
            $this->line("   📋 GHN Order Code: {$order->order_code}");
            $this->line("   📊 Status: {$order->status}");
            
            $this->line("");
            $this->info("🔄 Bây giờ bạn có thể test sync:");
            $this->line("   php artisan ghn:sync-order-status --order-code={$testOrderCode}");
            $this->line("   php artisan ghn:debug --test-sync");
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi tạo đơn hàng test: " . $e->getMessage());
        }
    }
}