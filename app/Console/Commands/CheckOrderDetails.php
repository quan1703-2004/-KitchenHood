<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class CheckOrderDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:order-details {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra chi tiết đơn hàng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $this->info("🔍 Kiểm tra đơn hàng ID: {$orderId}");
        
        $order = Order::find($orderId);
        if (!$order) {
            $this->error("❌ Không tìm thấy đơn hàng với ID: {$orderId}");
            return;
        }
        
        $this->info("📋 Order Number: {$order->order_number}");
        $this->info("📋 Order Code: '{$order->order_code}'");
        $this->info("👤 User ID: {$order->user_id}");
        $this->info("💰 Total Amount: " . number_format($order->total_amount) . " VNĐ");
        $this->info("💳 Payment Method: {$order->payment_method}");
        $this->info("📊 Payment Status: {$order->payment_status}");
        $this->info("📊 Status: {$order->status}");
        
        $this->info("📍 Shipping Info:");
        $this->info("  - Name: {$order->shipping_name}");
        $this->info("  - Phone: {$order->shipping_phone}");
        $this->info("  - Address: {$order->shipping_address}");
        $this->info("  - Province: '{$order->shipping_province_name}' (ID: {$order->shipping_province_id})");
        $this->info("  - District: '{$order->shipping_district_name}' (ID: {$order->shipping_district_id})");
        $this->info("  - Ward: '{$order->shipping_ward_name}' (ID: {$order->shipping_ward_id})");
        
        $this->info("📝 Notes: {$order->notes}");
        $this->info("🕒 Created: {$order->created_at}");
        $this->info("🕒 Updated: {$order->updated_at}");
        
        // Kiểm tra vấn đề với Province
        if (empty($order->shipping_province_name)) {
            $this->error("❌ VẤN ĐỀ: Province name trống!");
        }
        
        if (empty($order->shipping_district_name)) {
            $this->error("❌ VẤN ĐỀ: District name trống!");
        }
        
        if (empty($order->shipping_ward_name)) {
            $this->error("❌ VẤN ĐỀ: Ward name trống!");
        }
        
        if (empty($order->order_code)) {
            $this->warn("⚠️ Order code trống - GHN integration có thể thất bại");
        }
    }
}