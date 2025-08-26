<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo một số đơn hàng mẫu
        $orders = [
            [
                'order_number' => 'ORD-20250120-001',
                'customer_name' => 'Nguyễn Văn An',
                'customer_email' => 'nguyenvanan@example.com',
                'customer_phone' => '0123456789',
                'customer_address' => '123 Đường ABC, Phường 1, Quận 1, TP.HCM',
                'payment_method' => 'cod',
                'notes' => 'Giao hàng vào buổi sáng',
                'status' => 'pending',
                'total_amount' => 2500000,
                'shipping_fee' => 50000,
                'final_amount' => 2550000
            ],
            [
                'order_number' => 'ORD-20250120-002',
                'customer_name' => 'Trần Thị Bình',
                'customer_email' => 'tranthibinh@example.com',
                'customer_phone' => '0987654321',
                'customer_address' => '456 Đường XYZ, Phường 2, Quận 3, TP.HCM',
                'payment_method' => 'bank_transfer',
                'notes' => 'Giao hàng vào buổi chiều',
                'status' => 'processing',
                'total_amount' => 3500000,
                'shipping_fee' => 0,
                'final_amount' => 3500000
            ]
        ];

        foreach ($orders as $orderData) {
            $order = Order::create($orderData);
            
            // Tạo các mục đơn hàng
            $products = Product::inRandomOrder()->take(rand(1, 3))->get();
            
            foreach ($products as $product) {
                $quantity = rand(1, 3);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ]);
            }
        }
    }
}
