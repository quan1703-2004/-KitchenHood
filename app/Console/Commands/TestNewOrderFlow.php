<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Services\GhnService;
use App\Services\AddressMappingService;

class TestNewOrderFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:new-order-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test flow đặt hàng mới với AddressMappingService';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test flow đặt hàng mới với AddressMappingService...');
        
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
            
            // Tìm sản phẩm đầu tiên
            $product = Product::first();
            if (!$product) {
                $this->error('❌ Không tìm thấy sản phẩm nào trong database');
                return;
            }
            
            $this->info("👤 User: {$user->name} (ID: {$user->id})");
            $this->info("📍 Địa chỉ: {$address->full_address}");
            $this->info("🏢 Province: {$address->province_name} (ID: {$address->province_id})");
            $this->info("🏘️ District: {$address->district_name} (ID: {$address->district_id})");
            $this->info("🏘️ Ward: {$address->ward_name} (ID: {$address->ward_id})");
            $this->info("📦 Sản phẩm: {$product->name} (ID: {$product->id})");
            
            // Test address mapping với GHN API
            $this->info("🔍 Test address mapping với GHN API...");
            $mappingService = new AddressMappingService();
            $addressMapping = $mappingService->convertAddressToGhn($address);
            
            if ($addressMapping['success']) {
                $this->info("✅ Address mapping thành công!");
                $this->info("🏢 GHN Province ID: {$addressMapping['ghn_province_id']}");
                $this->info("🏘️ GHN District ID: {$addressMapping['ghn_district_id']}");
                $this->info("🏘️ GHN Ward Code: {$addressMapping['ghn_ward_code']}");
            } else {
                $this->error("❌ Address mapping thất bại: {$addressMapping['error']}");
                return;
            }
            
            // Tạo đơn hàng test
            $this->info("📋 Tạo đơn hàng test...");
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TEST-NEW-FLOW-' . date('YmdHis'),
                'order_code' => '',
                'subtotal' => $product->price,
                'shipping_fee' => 0,
                'total_amount' => $product->price,
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
                'notes' => 'Test new order flow',
                'status' => 'pending'
            ]);
            
            $this->info("✅ Đơn hàng được tạo thành công! ID: {$order->id}");
            
            // Test GHN integration với địa chỉ đã convert
            $this->info("🚚 Test GHN integration với địa chỉ đã convert...");
            $ghnService = new GhnService();
            
            $cartItems = [
                [
                    'product' => $product,
                    'quantity' => 1,
                    'subtotal' => $product->price,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price
                ]
            ];
            
            // Chuẩn bị dữ liệu cho GHN API với địa chỉ đã convert
            $orderData = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'shipping_name' => $order->shipping_name,
                'shipping_phone' => $order->shipping_phone,
                'shipping_address' => $order->shipping_address,
                'shipping_district_id' => $addressMapping['ghn_district_id'],
                'shipping_ward_code' => $addressMapping['ghn_ward_code'],
                'total_amount' => $order->total_amount,
                'notes' => $order->notes,
                'items' => $cartItems
            ];
            
            // Gọi GHN API
            $ghnResult = $ghnService->createShippingOrder($orderData);
            
            if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                $order->order_code = $ghnResult['data']['order_code'];
                $order->save();
                $this->info("🎉 GHN integration thành công!");
                $this->info("📋 GHN Order Code: {$order->order_code}");
            } else {
                $this->warn("⚠️ GHN integration thất bại nhưng đơn hàng vẫn được tạo");
                $this->line("Response: " . json_encode($ghnResult));
            }
            
            // Xóa đơn hàng test
            $order->delete();
            $this->info("🗑️ Đã xóa đơn hàng test");
            
            $this->info("🎉 Test hoàn thành!");
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}