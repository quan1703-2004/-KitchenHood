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
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestWebCheckoutFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:web-checkout-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test flow đặt hàng từ giao diện web';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test flow đặt hàng từ giao diện web...');
        
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
            
            // 2. Tạo cart và cart items
            $this->info('2️⃣ Tạo cart và cart items...');
            $cart = $user->carts()->firstOrCreate(['user_id' => $user->id]);
            $this->info("✅ Cart ID: {$cart->id}");
            
            // Thêm sản phẩm vào cart
            $product = Product::first();
            if (!$product) {
                $this->error('❌ Không tìm thấy sản phẩm nào');
                return;
            }
            
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
            
            $this->info("✅ Đã thêm sản phẩm vào cart: {$product->name}");
            
            // 3. Set session cart_selected_items
            $this->info('3️⃣ Set session cart_selected_items...');
            session(['cart_selected_items' => [$product->id]]);
            $this->info("✅ Session cart_selected_items: " . json_encode(session('cart_selected_items')));
            
            // 4. Mô phỏng request từ giao diện web
            $this->info('4️⃣ Mô phỏng request từ giao diện web...');
            $request = new Request();
            $request->merge([
                'address_id' => $address->id,
                'payment_method' => 'cod',
                'notes' => 'Test web checkout flow'
            ]);
            
            // Set Auth user
            Auth::login($user);
            
            // 5. Gọi CheckoutController store method
            $this->info('5️⃣ Gọi CheckoutController store method...');
            $checkoutController = new CheckoutController();
            $response = $checkoutController->store($request);
            
            $this->info("✅ CheckoutController store method hoàn thành");
            
            // 6. Kiểm tra đơn hàng được tạo
            $this->info('6️⃣ Kiểm tra đơn hàng được tạo...');
            $latestOrder = Order::orderBy('id', 'desc')->first();
            
            if ($latestOrder) {
                $this->info("✅ Đơn hàng được tạo thành công!");
                $this->info("📋 Order ID: {$latestOrder->id}");
                $this->info("📋 Order Number: {$latestOrder->order_number}");
                $this->info("📋 Order Code: '{$latestOrder->order_code}'");
                $this->info("💰 Total Amount: " . number_format($latestOrder->total_amount) . " VNĐ");
                $this->info("💳 Payment Method: {$latestOrder->payment_method}");
                $this->info("📊 Status: {$latestOrder->status}");
                
                if (!empty($latestOrder->order_code)) {
                    $this->info("🎉 GHN integration thành công! Order Code: {$latestOrder->order_code}");
                } else {
                    $this->warn("⚠️ GHN integration thất bại - Order Code trống");
                }
            } else {
                $this->error("❌ Không tìm thấy đơn hàng được tạo");
            }
            
            DB::rollBack(); // Rollback để giữ database sạch
            $this->info("🗑️ Đã xóa đơn hàng test");
            
            $this->info('🎉 Test flow đặt hàng từ giao diện web hoàn thành!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}