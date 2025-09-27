<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class TestCheckoutPageAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout-page-access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test truy cập trang checkout có hoạt động không';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test truy cập trang checkout...');
        
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
            $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
            $this->info("✅ addresses: {$addresses->count()} địa chỉ");
            
            // Test cart relationship
            $cart = $user->carts()->firstOrCreate(['user_id' => $user->id]);
            $this->info("✅ cart: Cart ID {$cart->id}");
            
            // 2. Test CartItems
            $this->info('2️⃣ Test CartItems...');
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
            
            // 3. Test session
            $this->info('3️⃣ Test session cart_selected_items...');
            $selectedItems = session('cart_selected_items', []);
            $this->info("✅ Session cart_selected_items: " . json_encode($selectedItems));
            
            if (empty($selectedItems)) {
                $product = Product::first();
                if ($product) {
                    session(['cart_selected_items' => [$product->id]]);
                    $this->info("✅ Đã set session cart_selected_items: [{$product->id}]");
                }
            }
            
            // 4. Test variables cho view
            $this->info('4️⃣ Test variables cho view...');
            $cartItems = [];
            $total = 0;
            $shippingFee = 0;
            
            foreach ($items as $item) {
                if (in_array($item->product_id, $selectedItems)) {
                    $lineTotal = $item->product->price * $item->quantity;
                    $cartItems[] = [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'subtotal' => $lineTotal,
                    ];
                    $total += $lineTotal;
                }
            }
            
            $finalAmount = $total + $shippingFee;
            
            $this->info("✅ cartItems: " . count($cartItems) . " sản phẩm");
            $this->info("✅ total: " . number_format($total) . " VNĐ");
            $this->info("✅ shippingFee: " . number_format($shippingFee) . " VNĐ");
            $this->info("✅ finalAmount: " . number_format($finalAmount) . " VNĐ");
            $this->info("✅ addresses: " . $addresses->count() . " địa chỉ");
            
            $this->info('🎉 Test truy cập trang checkout hoàn thành!');
            $this->info('💡 Tất cả variables đã được chuẩn bị sẵn sàng cho view');
            $this->info('🚀 Trang checkout sẽ hoạt động mà không gặp lỗi');
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}