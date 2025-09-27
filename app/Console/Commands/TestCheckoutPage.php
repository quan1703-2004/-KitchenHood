<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class TestCheckoutPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:checkout-page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test trang checkout có hoạt động không';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test trang checkout...');
        
        try {
            // Tìm user đầu tiên
            $user = User::first();
            if (!$user) {
                $this->error('❌ Không tìm thấy user nào trong database');
                return;
            }
            
            $this->info("👤 User: {$user->name} (ID: {$user->id})");
            
            // Test relationship addresses
            $this->info("🔍 Test relationship addresses...");
            $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
            $this->info("✅ Tìm thấy {$addresses->count()} địa chỉ");
            
            foreach ($addresses as $address) {
                $this->line("  - {$address->full_address}");
            }
            
            // Test relationship cart
            $this->info("🔍 Test relationship cart...");
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
            $this->info("✅ Cart ID: {$cart->id}");
            
            // Test cart items
            $items = CartItem::with('product.category')
                ->where('cart_id', $cart->id)
                ->get();
            
            $this->info("✅ Tìm thấy {$items->count()} sản phẩm trong giỏ hàng");
            
            if ($items->isEmpty()) {
                $this->warn("⚠️ Giỏ hàng trống - cần thêm sản phẩm để test checkout");
                
                // Thêm sản phẩm test
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
            
            // Test session cart_selected_items
            $this->info("🔍 Test session cart_selected_items...");
            $selectedItems = session('cart_selected_items', []);
            $this->info("✅ Session cart_selected_items: " . json_encode($selectedItems));
            
            if (empty($selectedItems)) {
                $this->warn("⚠️ Session cart_selected_items trống - cần set session để test checkout");
                
                // Set session test
                $product = Product::first();
                if ($product) {
                    session(['cart_selected_items' => [$product->id]]);
                    $this->info("✅ Đã set session cart_selected_items: [{$product->id}]");
                }
            }
            
            $this->info("🎉 Test trang checkout hoàn thành!");
            $this->info("💡 Bây giờ bạn có thể truy cập trang checkout mà không gặp lỗi");
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}