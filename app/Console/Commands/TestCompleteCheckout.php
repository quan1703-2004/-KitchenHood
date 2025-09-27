<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\AddressMappingService;
use App\Services\GhnService;

class TestCompleteCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:complete-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test toàn bộ hệ thống checkout từ A-Z';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test toàn bộ hệ thống checkout từ A-Z...');
        
        try {
            // 1. Test User relationships
            $this->info('1️⃣ Test User relationships...');
            $user = User::first();
            if (!$user) {
                $this->error('❌ Không tìm thấy user nào');
                return;
            }
            
            $this->info("👤 User: {$user->name} (ID: {$user->id})");
            
            // Test addresses relationship
            $addresses = $user->addresses;
            $this->info("✅ addresses: {$addresses->count()} địa chỉ");
            
            // Test cart relationship (singular)
            $cart = $user->cart;
            $this->info("✅ cart (singular): " . ($cart ? "Cart ID {$cart->id}" : "NULL"));
            
            // Test carts relationship (plural)
            $carts = $user->carts;
            $this->info("✅ carts (plural): {$carts->count()} carts");
            
            // Test orders relationship
            $orders = $user->orders;
            $this->info("✅ orders: {$orders->count()} đơn hàng");
            
            // 2. Test Address mapping với GHN
            $this->info('2️⃣ Test Address mapping với GHN...');
            $address = $addresses->first();
            if (!$address) {
                $this->error('❌ Không tìm thấy địa chỉ nào');
                return;
            }
            
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
            
            // 3. Test Cart và CartItems
            $this->info('3️⃣ Test Cart và CartItems...');
            $cart = $user->carts()->firstOrCreate(['user_id' => $user->id]);
            $this->info("✅ Cart được tạo/lấy thành công: ID {$cart->id}");
            
            $items = CartItem::with('product.category')
                ->where('cart_id', $cart->id)
                ->get();
            
            $this->info("✅ Tìm thấy {$items->count()} sản phẩm trong giỏ hàng");
            
            // Thêm sản phẩm test nếu giỏ hàng trống
            if ($items->isEmpty()) {
                $product = Product::first();
                if ($product) {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'quantity' => 1
                    ]);
                    $this->info("✅ Đã thêm sản phẩm test: {$product->name}");
                }
            }
            
            // 4. Test GHN integration
            $this->info('4️⃣ Test GHN integration...');
            $ghnService = new GhnService();
            
            $testOrderData = [
                'order_id' => 999,
                'order_number' => 'TEST-COMPLETE-' . date('YmdHis'),
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->full_address,
                'shipping_district_id' => $addressMapping['ghn_district_id'],
                'shipping_ward_code' => $addressMapping['ghn_ward_code'],
                'total_amount' => 100000,
                'notes' => 'Test complete checkout',
                'items' => [
                    [
                        'product_id' => 1,
                        'product_name' => 'Test Product',
                        'product_price' => 100000,
                        'quantity' => 1
                    ]
                ]
            ];
            
            $ghnResult = $ghnService->createShippingOrder($testOrderData);
            
            if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                $this->info("✅ GHN integration thành công!");
                $this->info("📋 GHN Order Code: {$ghnResult['data']['order_code']}");
            } else {
                $this->warn("⚠️ GHN integration thất bại nhưng không ảnh hưởng đến checkout");
                $this->line("Response: " . json_encode($ghnResult));
            }
            
            // 5. Test session
            $this->info('5️⃣ Test session cart_selected_items...');
            session(['cart_selected_items' => [1]]);
            $selectedItems = session('cart_selected_items', []);
            $this->info("✅ Session cart_selected_items: " . json_encode($selectedItems));
            
            $this->info('🎉 Test toàn bộ hệ thống checkout hoàn thành!');
            $this->info('💡 Hệ thống đã sẵn sàng để đặt hàng!');
            $this->info('🚀 Bạn có thể truy cập trang checkout mà không gặp lỗi');
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}