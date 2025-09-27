<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderItem;

class CleanupTestOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:test-orders {--dry-run : Chỉ hiển thị mà không xóa}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup test orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info("🔍 DRY RUN - Chỉ hiển thị, không xóa");
        } else {
            $this->warn("⚠️ SẼ XÓA CÁC ĐƠN HÀNG TEST!");
        }
        
        $this->line("");
        
        // Tìm các đơn hàng test
        $testOrders = Order::where('order_number', 'LIKE', 'TEST-%')
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        if ($testOrders->count() == 0) {
            $this->info("✅ Không có đơn hàng test nào để xóa");
            return;
        }
        
        $this->line("📋 Found {$testOrders->count()} test orders:");
        
        foreach ($testOrders as $order) {
            $this->line("   - {$order->order_number} ({$order->order_code}) - {$order->created_at}");
            
            if (!$isDryRun) {
                // Xóa order items trước
                OrderItem::where('order_id', $order->id)->delete();
                
                // Xóa order
                $order->delete();
                
                $this->info("   ✅ Đã xóa: {$order->order_number}");
            }
        }
        
        if ($isDryRun) {
            $this->line("");
            $this->info("💡 Để thực sự xóa, chạy: php artisan cleanup:test-orders");
        } else {
            $this->line("");
            $this->info("✅ Đã xóa {$testOrders->count()} đơn hàng test");
        }
    }
}