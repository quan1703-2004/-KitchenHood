<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class CheckLatestOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:latest-orders {--limit=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra đơn hàng mới nhất';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $this->info("🔍 Kiểm tra {$limit} đơn hàng mới nhất...");
        
        $orders = Order::orderBy('id', 'desc')->take($limit)->get();
        
        if ($orders->isEmpty()) {
            $this->error('❌ Không tìm thấy đơn hàng nào');
            return;
        }
        
        $this->info("📋 Tìm thấy {$orders->count()} đơn hàng:");
        
        foreach ($orders as $order) {
            $this->line("ID: {$order->id} | Number: {$order->order_number} | Code: '{$order->order_code}' | Created: {$order->created_at}");
        }
        
        // Kiểm tra đơn hàng có mã GHN
        $ordersWithCode = $orders->where('order_code', '!=', '')->where('order_code', '!=', null);
        $this->info("✅ Đơn hàng có mã GHN: {$ordersWithCode->count()}");
        
        // Kiểm tra đơn hàng không có mã GHN
        $ordersWithoutCode = $orders->filter(function($order) {
            return empty($order->order_code);
        });
        $this->info("⚠️ Đơn hàng không có mã GHN: {$ordersWithoutCode->count()}");
        
        if ($ordersWithoutCode->count() > 0) {
            $this->warn("📋 Đơn hàng cần cập nhật mã GHN:");
            foreach ($ordersWithoutCode as $order) {
                $this->line("  - ID: {$order->id} | Number: {$order->order_number}");
            }
        }
    }
}