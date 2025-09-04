<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Models\User;

class InventoryTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy admin user đầu tiên
        $adminUser = User::where('role', 'admin')->first();
        
        if (!$adminUser) {
            $this->command->error('Không tìm thấy admin user. Vui lòng chạy AdminSeeder trước.');
            return;
        }

        // Lấy tất cả sản phẩm
        $products = Product::all();

        foreach ($products as $product) {
            // Tạo giao dịch nhập hàng ban đầu cho mỗi sản phẩm
            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $product->quantity,
                'quantity_before' => 0,
                'quantity_after' => $product->quantity,
                'notes' => 'Nhập hàng ban đầu',
                'user_id' => $adminUser->id
            ]);

            // Tạo một số giao dịch xuất hàng mẫu (nếu có đơn hàng)
            $orderItems = \App\Models\OrderItem::where('product_id', $product->id)
                ->with('order')
                ->get();
            
            foreach ($orderItems as $orderItem) {
                if ($orderItem->order && $orderItem->order->status === 'delivered') {
                    InventoryTransaction::create([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'quantity' => $orderItem->quantity,
                        'quantity_before' => $product->quantity + $orderItem->quantity,
                        'quantity_after' => $product->quantity,
                        'notes' => "Xuất hàng cho đơn hàng #{$orderItem->order->order_number}",
                        'order_id' => $orderItem->order->id,
                        'user_id' => $adminUser->id
                    ]);
                }
            }
        }

        $this->command->info('Đã tạo dữ liệu mẫu cho giao dịch tồn kho.');
    }
}
