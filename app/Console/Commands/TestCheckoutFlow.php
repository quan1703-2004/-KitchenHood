<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\AddressMappingService;

class TestCheckoutFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test checkout flow và address mapping';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🛒 Testing Checkout Flow...");
        
        try {
            // Tìm user đầu tiên
            $user = User::first();
            if (!$user) {
                $this->error("❌ Không có user nào trong hệ thống");
                return;
            }
            
            $this->line("👤 User: {$user->name} ({$user->email})");
            
            // Kiểm tra địa chỉ của user
            $addresses = $user->addresses;
            $this->line("📍 Số địa chỉ: " . $addresses->count());
            
            if ($addresses->count() > 0) {
                $address = $addresses->first();
                $this->line("📍 Địa chỉ test:");
                $this->line("   - Tỉnh: {$address->province_name}");
                $this->line("   - Quận/Huyện: {$address->district_name}");
                $this->line("   - Phường/Xã: {$address->ward_name}");
                $this->line("   - Địa chỉ: {$address->full_address}");
                
                // Test address mapping
                $this->line("");
                $this->info("🗺️ Testing Address Mapping...");
                
                $mappingService = new AddressMappingService();
                $mappingResult = $mappingService->convertAddressToGhn($address);
                
                if ($mappingResult['success']) {
                    $this->info("✅ Address mapping thành công:");
                    $this->line("   - GHN Province ID: {$mappingResult['ghn_province_id']}");
                    $this->line("   - GHN District ID: {$mappingResult['ghn_district_id']}");
                    $this->line("   - GHN Ward Code: {$mappingResult['ghn_ward_code']}");
                } else {
                    $this->error("❌ Address mapping thất bại: {$mappingResult['error']}");
                }
            } else {
                $this->warn("⚠️ User chưa có địa chỉ nào");
            }
            
            // Kiểm tra giỏ hàng
            $cart = $user->carts()->first();
            if ($cart) {
                $cartItems = $cart->items()->with('product')->get();
                $this->line("");
                $this->line("🛒 Giỏ hàng:");
                $this->line("   - Số sản phẩm: " . $cartItems->count());
                
                foreach ($cartItems as $item) {
                    if ($item->product) {
                        $this->line("   - {$item->product->name} x{$item->quantity}");
                    }
                }
            } else {
                $this->warn("⚠️ User chưa có giỏ hàng");
            }
            
            // Kiểm tra sản phẩm có sẵn
            $products = Product::where('quantity', '>', 0)->limit(3)->get();
            $this->line("");
            $this->line("📦 Sản phẩm có sẵn:");
            foreach ($products as $product) {
                $this->line("   - {$product->name} (Còn: {$product->quantity})");
            }
            
            $this->line("");
            $this->info("✅ Test hoàn thành!");
            $this->line("");
            $this->info("🔧 Để test checkout thực tế:");
            $this->line("   1. Đăng nhập với user: {$user->email}");
            $this->line("   2. Thêm sản phẩm vào giỏ hàng");
            $this->line("   3. Truy cập /checkout");
            $this->line("   4. Chọn địa chỉ và phương thức thanh toán");
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi test: " . $e->getMessage());
        }
    }
}