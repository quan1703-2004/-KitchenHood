<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnOrderStatusSyncService;
use App\Models\Order;

class SyncOrderStatusFromGhn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:sync-order-status {--order-code=} {--all} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Đồng bộ trạng thái đơn hàng từ GHN API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $syncService = new GhnOrderStatusSyncService();
        
        if ($this->option('order-code')) {
            $this->syncSingleOrder($syncService, $this->option('order-code'));
        } elseif ($this->option('all')) {
            $this->syncAllOrders($syncService);
        } else {
            $this->showHelp();
        }
    }

    /**
     * Đồng bộ một đơn hàng cụ thể
     */
    private function syncSingleOrder(GhnOrderStatusSyncService $syncService, string $orderCode): void
    {
        $this->info("🔄 Đồng bộ trạng thái đơn hàng: {$orderCode}");
        
        // Tìm đơn hàng trong hệ thống
        $order = Order::where('order_code', $orderCode)->first();
        
        if (!$order) {
            $this->error("❌ Không tìm thấy đơn hàng với mã GHN: {$orderCode}");
            return;
        }
        
        $this->info("📋 Đơn hàng: {$order->order_number} (ID: {$order->id})");
        $this->info("📊 Trạng thái hiện tại: {$order->status}");
        
        // Đồng bộ từ GHN
        $result = $syncService->syncOrderStatus($orderCode);
        
        if ($result['success']) {
            $this->info("✅ Đồng bộ thành công từ GHN");
            $this->info("📊 Trạng thái GHN: {$result['ghn_status']}");
            $this->info("📊 Trạng thái hệ thống: {$result['system_status']}");
            
            // Cập nhật trạng thái nếu khác nhau
            if ($result['system_status'] !== $order->status) {
                if ($syncService->updateOrderStatus($order, $result['system_status'])) {
                    $this->info("🔄 Đã cập nhật trạng thái: {$order->status} → {$result['system_status']}");
                } else {
                    $this->error("❌ Không thể cập nhật trạng thái");
                }
            } else {
                $this->info("ℹ️ Trạng thái không thay đổi");
            }
        } else {
            $this->error("❌ Đồng bộ thất bại: {$result['error']}");
        }
    }

    /**
     * Đồng bộ tất cả đơn hàng
     */
    private function syncAllOrders(GhnOrderStatusSyncService $syncService): void
    {
        $this->info("🔄 Đồng bộ trạng thái tất cả đơn hàng từ GHN...");
        
        $results = $syncService->syncAllOrdersWithGhnCode();
        
        $this->info("📊 Kết quả đồng bộ:");
        $this->info("   📋 Tổng số đơn hàng: {$results['total']}");
        $this->info("   ✅ Thành công: {$results['success']}");
        $this->info("   ❌ Thất bại: {$results['failed']}");
        $this->info("   🔄 Đã cập nhật: {$results['updated']}");
        
        if ($results['updated'] > 0) {
            $this->info("\n🔄 Các đơn hàng đã được cập nhật:");
            foreach ($results['details'] as $detail) {
                if ($detail['action'] === 'updated') {
                    $this->line("   📋 {$detail['order_number']} ({$detail['ghn_order_code']}): {$detail['old_status']} → {$detail['new_status']}");
                }
            }
        }
        
        if ($results['failed'] > 0) {
            $this->warn("\n❌ Các đơn hàng đồng bộ thất bại:");
            foreach ($results['details'] as $detail) {
                if ($detail['action'] === 'failed') {
                    $this->line("   📋 {$detail['order_number']} ({$detail['ghn_order_code']}): {$detail['error']}");
                }
            }
        }
    }

    /**
     * Hiển thị hướng dẫn sử dụng
     */
    private function showHelp(): void
    {
        $this->info("🔄 GHN Order Status Sync Command");
        $this->line("");
        $this->info("Cách sử dụng:");
        $this->line("  php artisan ghn:sync-order-status --order-code=L3A47F");
        $this->line("  php artisan ghn:sync-order-status --all");
        $this->line("");
        $this->info("Tùy chọn:");
        $this->line("  --order-code=CODE    Đồng bộ đơn hàng cụ thể");
        $this->line("  --all                Đồng bộ tất cả đơn hàng");
        $this->line("  --force              Bắt buộc cập nhật (bỏ qua kiểm tra)");
        $this->line("");
        $this->info("Ví dụ:");
        $this->line("  php artisan ghn:sync-order-status --order-code=L3A47F");
        $this->line("  php artisan ghn:sync-order-status --all");
    }
}