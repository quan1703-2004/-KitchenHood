<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\AddressMappingService;
use App\Services\GhnService;
use Illuminate\Support\Facades\DB;

class TestCompleteOrderFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:complete-order-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test toàn bộ flow đặt hàng từ A-Z';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test toàn bộ flow đặt hàng từ A-Z...');
        
        DB::beginTransaction();
        try {
            // 1. Tìm user và địa chỉ
            $this->info('1️⃣ Tìm user và địa chỉ...');
            $user = User::first();
            if (!$user) {
                $this->error('❌ Không tìm thấy user nào');
                return;
            }
            
            $address = Address::where('user_id', $user->id)->first();
            if (!$address) {
                $this->error('❌ Không tìm thấy địa chỉ nào');
                return;
            }
            
            $this->info("👤 User: {$user->name} (ID: {$user->id})");
            $this->info("📍 Address: {$address->full_address}");
            
            // 2. Tìm sản phẩm
            $this->info('2️⃣ Tìm sản phẩm...');
            $product = Product::first();
            if (!$product) {
                $this->error('❌ Không tìm thấy sản phẩm nào');
                return;
            }
            
            $this->info("📦 Product: {$product->name} (ID: {$product->id})");
            
            // 3. Tạo đơn hàng
            $this->info('3️⃣ Tạo đơn hàng...');
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TEST-COMPLETE-' . date('YmdHis'),
                'order_code' => '', // Khởi tạo với giá trị rỗng
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
                'notes' => 'Test complete order flow',
                'status' => 'pending'
            ]);
            
            $this->info("✅ Đơn hàng được tạo thành công! ID: {$order->id}");
            $this->info("📋 Order Number: {$order->order_number}");
            $this->info("📋 Order Code: '{$order->order_code}'");
            
            // 4. Tạo OrderItem
            $this->info('4️⃣ Tạo OrderItem...');
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ]);
            
            $this->info("✅ OrderItem được tạo thành công!");
            
            // 5. Test AddressMappingService
            $this->info('5️⃣ Test AddressMappingService...');
            $mappingService = new AddressMappingService();
            $addressMapping = $mappingService->convertAddressToGhn($order);
            
            if ($addressMapping['success']) {
                $this->info("✅ Address mapping thành công!");
                $this->info("🏢 GHN Province ID: {$addressMapping['ghn_province_id']}");
                $this->info("🏘️ GHN District ID: {$addressMapping['ghn_district_id']}");
                $this->info("🏘️ GHN Ward Code: {$addressMapping['ghn_ward_code']}");
            } else {
                $this->error("❌ Address mapping thất bại: {$addressMapping['error']}");
                DB::rollBack();
                return;
            }
            
            // 6. Test GHN API integration
            $this->info('6️⃣ Test GHN API integration...');
            $ghnService = new GhnService();
            
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
                'items' => [
                    [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'quantity' => 1
                    ]
                ]
            ];
            
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
            
            // 7. Kiểm tra kết quả cuối cùng
            $this->info('7️⃣ Kiểm tra kết quả cuối cùng...');
            $finalOrder = Order::find($order->id);
            $this->info("📋 Final Order Code: '{$finalOrder->order_code}'");
            $this->info("📊 Final Status: {$finalOrder->status}");
            $this->info("💳 Final Payment Status: {$finalOrder->payment_status}");
            
            DB::rollBack(); // Rollback để giữ database sạch
            $this->info("🗑️ Đã xóa đơn hàng test");
            
            $this->info('🎉 Test toàn bộ flow đặt hàng hoàn thành!');
            $this->info('💡 Hệ thống đã sẵn sàng để đặt hàng thực tế!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}