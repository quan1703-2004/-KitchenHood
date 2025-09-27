<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;

class TestOrderCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:order-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test tạo đơn hàng trong database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test tạo đơn hàng trong database...');
        
        try {
            // Tìm user đầu tiên
            $user = User::first();
            if (!$user) {
                $this->error('❌ Không tìm thấy user nào trong database');
                return;
            }
            
            // Tìm địa chỉ của user
            $address = Address::where('user_id', $user->id)->first();
            if (!$address) {
                $this->error('❌ Không tìm thấy địa chỉ của user');
                return;
            }
            
            $this->info("👤 User: {$user->name} (ID: {$user->id})");
            $this->info("📍 Địa chỉ: {$address->full_address}");
            $this->info("🏢 District ID: {$address->district_id}");
            $this->info("🏘️ Ward ID: {$address->ward_id}");
            
            // Test tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TEST-' . date('YmdHis'),
                'order_code' => '', // Khởi tạo với giá trị rỗng
                'subtotal' => 100000,
                'shipping_fee' => 0,
                'total_amount' => 100000,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->full_address,
                'shipping_province_id' => $address->province_id,
                'shipping_province_name' => $address->province_name,
                'shipping_district_id' => $address->district_id,
                'shipping_district_name' => $address->district_name,
                'shipping_ward_id' => $address->ward_id,
                'shipping_ward_name' => $address->ward_name,
                'notes' => 'Test order',
                'status' => 'pending'
            ]);
            
            $this->info("✅ Đơn hàng được tạo thành công!");
            $this->info("📋 Order ID: {$order->id}");
            $this->info("📋 Order Number: {$order->order_number}");
            $this->info("📋 Order Code: '{$order->order_code}'");
            
            // Test cập nhật order_code
            $order->order_code = 'TEST-GHN-CODE';
            $order->save();
            
            $this->info("✅ Cập nhật order_code thành công!");
            $this->info("📋 Order Code sau cập nhật: '{$order->order_code}'");
            
            // Xóa đơn hàng test
            $order->delete();
            $this->info("🗑️ Đã xóa đơn hàng test");
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}