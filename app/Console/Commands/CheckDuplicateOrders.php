<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class CheckDuplicateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:duplicate-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for duplicate orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 Checking for duplicate orders...");
        
        // Kiểm tra các đơn hàng có mã GHN gần đây
        $orders = Order::whereNotNull('order_code')
                      ->where('order_code', '!=', '')
                      ->orderBy('created_at', 'desc')
                      ->limit(10)
                      ->get(['id', 'order_number', 'order_code', 'created_at', 'shipping_name', 'shipping_phone']);
        
        $this->line("📋 Recent orders with GHN codes:");
        foreach ($orders as $order) {
            $this->line("   - {$order->order_number} ({$order->order_code}) - {$order->shipping_name} - {$order->created_at}");
        }
        
        // Kiểm tra duplicate theo shipping_name và phone
        $this->line("");
        $this->info("🔍 Checking for duplicates by recipient...");
        
        $duplicates = Order::select('shipping_name', 'shipping_phone', \DB::raw('COUNT(*) as count'))
                          ->whereNotNull('order_code')
                          ->where('order_code', '!=', '')
                          ->groupBy('shipping_name', 'shipping_phone')
                          ->having('count', '>', 1)
                          ->get();
        
        if ($duplicates->count() > 0) {
            $this->warn("⚠️ Found potential duplicates:");
            foreach ($duplicates as $dup) {
                $this->line("   - {$dup->shipping_name} ({$dup->shipping_phone}): {$dup->count} orders");
                
                // Hiển thị chi tiết các đơn hàng duplicate
                $orders = Order::where('shipping_name', $dup->shipping_name)
                             ->where('shipping_phone', $dup->shipping_phone)
                             ->whereNotNull('order_code')
                             ->get(['order_number', 'order_code', 'created_at']);
                
                foreach ($orders as $order) {
                    $this->line("     * {$order->order_number} ({$order->order_code}) - {$order->created_at}");
                }
            }
        } else {
            $this->info("✅ No duplicates found by recipient");
        }
        
        // Kiểm tra các đơn hàng test
        $this->line("");
        $this->info("🧪 Checking test orders...");
        
        $testOrders = Order::where('order_number', 'LIKE', 'TEST-%')
                          ->orderBy('created_at', 'desc')
                          ->get(['id', 'order_number', 'order_code', 'created_at']);
        
        $this->line("📋 Test orders:");
        foreach ($testOrders as $order) {
            $this->line("   - {$order->order_number} ({$order->order_code}) - {$order->created_at}");
        }
        
        if ($testOrders->count() > 1) {
            $this->warn("⚠️ Found {$testOrders->count()} test orders - this might explain the duplicates");
        }
    }
}