<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\GhnService;
use App\Services\AddressMappingService;

class TestGhnOrderCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ghn-order-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test tạo đơn hàng GHN thực tế';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🚚 Testing GHN Order Creation...");
        
        try {
            // Tìm user và địa chỉ
            $user = User::first();
            if (!$user) {
                $this->error("❌ Không có user nào trong hệ thống");
                return;
            }
            
            $address = $user->addresses()->first();
            if (!$address) {
                $this->error("❌ User chưa có địa chỉ");
                return;
            }
            
            // Tìm sản phẩm
            $product = Product::where('quantity', '>', 0)->first();
            if (!$product) {
                $this->error("❌ Không có sản phẩm nào trong kho");
                return;
            }
            
            $this->line("👤 User: {$user->name}");
            $this->line("📍 Địa chỉ: {$address->full_address}");
            $this->line("📦 Sản phẩm: {$product->name}");
            
            // Test address mapping
            $this->line("");
            $this->info("🗺️ Testing Address Mapping...");
            
            $mappingService = new AddressMappingService();
            $mappingResult = $mappingService->convertAddressToGhn($address);
            
            if (!$mappingResult['success']) {
                $this->error("❌ Address mapping thất bại: {$mappingResult['error']}");
                return;
            }
            
            $this->info("✅ Address mapping thành công:");
            $this->line("   - GHN Province ID: {$mappingResult['ghn_province_id']}");
            $this->line("   - GHN District ID: {$mappingResult['ghn_district_id']}");
            $this->line("   - GHN Ward Code: {$mappingResult['ghn_ward_code']}");
            
            // Tạo đơn hàng test
            $this->line("");
            $this->info("📋 Creating test order...");
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TEST-' . date('YmdHis'),
                'order_code' => '', // Sẽ được cập nhật sau khi gọi GHN
                'status' => 'pending',
                'subtotal' => $product->price,
                'shipping_fee' => 30000,
                'discount_amount' => 0,
                'total_amount' => $product->price + 30000,
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
                'shipping_ward_code' => $mappingResult['ghn_ward_code'],
                'notes' => 'Đơn hàng test GHN'
            ]);
            
            // Tạo order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ]);
            
            $this->info("✅ Đã tạo đơn hàng: {$order->order_number}");
            
            // Test tạo đơn hàng GHN
            $this->line("");
            $this->info("🚚 Testing GHN Order Creation...");
            
            $ghnService = new GhnService();
            
            $ghnItems = [
                [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => 1
                ]
            ];
            
            $orderData = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'shipping_name' => $order->shipping_name,
                'shipping_phone' => $order->shipping_phone,
                'shipping_address' => $order->shipping_address,
                'shipping_district_id' => $mappingResult['ghn_district_id'],
                'shipping_ward_code' => $mappingResult['ghn_ward_code'],
                'total_amount' => $order->total_amount,
                'notes' => $order->notes,
                'items' => $ghnItems,
                'is_prepaid' => false // COD
            ];
            
            $ghnResult = $ghnService->createShippingOrder($orderData);
            
            if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                // Cập nhật mã đơn hàng GHN
                $order->order_code = $ghnResult['data']['order_code'];
                $order->save();
                
                $this->info("✅ GHN Order Creation thành công!");
                $this->line("   📋 Order ID: {$order->id}");
                $this->line("   📋 Order Number: {$order->order_number}");
                $this->line("   🚚 GHN Order Code: {$order->order_code}");
                
                $this->line("");
                $this->info("🔧 Để test sync status:");
                $this->line("   php artisan ghn:sync-order-status --order-code={$order->order_code}");
                
            } else {
                $this->error("❌ GHN Order Creation thất bại");
                $this->line("   Response: " . json_encode($ghnResult));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("📍 File: " . $e->getFile() . ":" . $e->getLine());
        }
    }
}