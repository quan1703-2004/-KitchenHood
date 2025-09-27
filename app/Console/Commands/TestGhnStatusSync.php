<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnOrderStatusSyncService;
use App\Models\Order;

class TestGhnStatusSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ghn-status-sync {--order-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test đồng bộ trạng thái đơn hàng từ GHN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test đồng bộ trạng thái đơn hàng từ GHN...');
        
        $syncService = new GhnOrderStatusSyncService();
        
        if ($this->option('order-id')) {
            $this->testSingleOrder($syncService, $this->option('order-id'));
        } else {
            $this->testAllOrders($syncService);
        }
    }

    /**
     * Test đồng bộ một đơn hàng cụ thể
     */
    private function testSingleOrder(GhnOrderStatusSyncService $syncService, int $orderId): void
    {
        $this->info("🔍 Test đồng bộ đơn hàng ID: {$orderId}");
        
        $order = Order::find($orderId);
        
        if (!$order) {
            $this->error("❌ Không tìm thấy đơn hàng với ID: {$orderId}");
            return;
        }
        
        if (empty($order->order_code)) {
            $this->error("❌ Đơn hàng không có mã GHN");
            return;
        }
        
        $this->info("📋 Order: {$order->order_number}");
        $this->info("📋 GHN Code: {$order->order_code}");
        $this->info("📊 Current Status: {$order->status}");
        
        // Test đồng bộ
        $this->info("🔄 Test đồng bộ từ GHN...");
        $result = $syncService->syncOrderStatus($order->order_code);
        
        if ($result['success']) {
            $this->info("✅ Đồng bộ thành công!");
            $this->info("📊 GHN Status: {$result['ghn_status']}");
            $this->info("📊 System Status: {$result['system_status']}");
            
            if ($result['system_status'] !== $order->status) {
                $this->warn("⚠️ Trạng thái khác nhau!");
                $this->info("   Hệ thống: {$order->status}");
                $this->info("   GHN: {$result['system_status']}");
                
                if ($this->confirm('Bạn có muốn cập nhật trạng thái không?')) {
                    if ($syncService->updateOrderStatus($order, $result['system_status'])) {
                        $this->info("✅ Đã cập nhật trạng thái!");
                    } else {
                        $this->error("❌ Không thể cập nhật trạng thái");
                    }
                }
            } else {
                $this->info("ℹ️ Trạng thái đã đồng bộ");
            }
        } else {
            $this->error("❌ Đồng bộ thất bại: {$result['error']}");
        }
    }

    /**
     * Test đồng bộ tất cả đơn hàng
     */
    private function testAllOrders(GhnOrderStatusSyncService $syncService): void
    {
        $this->info("🔍 Test đồng bộ tất cả đơn hàng...");
        
        // Lấy danh sách đơn hàng có mã GHN
        $orders = Order::whereNotNull('order_code')
                      ->where('order_code', '!=', '')
                      ->orderBy('id', 'desc')
                      ->take(5)
                      ->get();
        
        if ($orders->isEmpty()) {
            $this->error("❌ Không tìm thấy đơn hàng nào có mã GHN");
            return;
        }
        
        $this->info("📋 Tìm thấy {$orders->count()} đơn hàng có mã GHN:");
        
        foreach ($orders as $order) {
            $this->line("   ID: {$order->id} | Number: {$order->order_number} | Code: {$order->order_code} | Status: {$order->status}");
        }
        
        $this->info("\n🔄 Test đồng bộ từng đơn hàng...");
        
        foreach ($orders as $order) {
            $this->line("\n📋 Test đơn hàng: {$order->order_number} ({$order->order_code})");
            
            $result = $syncService->syncOrderStatus($order->order_code);
            
            if ($result['success']) {
                $this->info("   ✅ GHN Status: {$result['ghn_status']} | System Status: {$result['system_status']}");
                
                if ($result['system_status'] !== $order->status) {
                    $this->warn("   ⚠️ Trạng thái khác nhau!");
                } else {
                    $this->info("   ℹ️ Trạng thái đồng bộ");
                }
            } else {
                $this->error("   ❌ Lỗi: {$result['error']}");
            }
        }
        
        // Test đồng bộ tất cả
        $this->info("\n🔄 Test đồng bộ tất cả đơn hàng...");
        $results = $syncService->syncAllOrdersWithGhnCode();
        
        $this->info("📊 Kết quả:");
        $this->info("   📋 Tổng số: {$results['total']}");
        $this->info("   ✅ Thành công: {$results['success']}");
        $this->info("   ❌ Thất bại: {$results['failed']}");
        $this->info("   🔄 Đã cập nhật: {$results['updated']}");
    }
}