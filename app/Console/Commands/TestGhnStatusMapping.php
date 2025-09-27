<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnOrderStatusSyncService;

class TestGhnStatusMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ghn-status-mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test mapping trạng thái GHN sang hệ thống';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test mapping trạng thái GHN sang hệ thống...');
        
        $syncService = new GhnOrderStatusSyncService();
        $statusList = $syncService->getGhnStatusList();
        
        $this->info("📋 Danh sách trạng thái GHN và mapping:");
        $this->line("");
        
        foreach ($statusList as $ghnStatus => $description) {
            // Sử dụng reflection để gọi private method
            $reflection = new \ReflectionClass($syncService);
            $method = $reflection->getMethod('mapGhnStatusToSystem');
            $method->setAccessible(true);
            $systemStatus = $method->invoke($syncService, $ghnStatus);
            
            $this->line("📊 {$ghnStatus} → {$systemStatus}");
            $this->line("   📝 {$description}");
            $this->line("");
        }
        
        $this->info("✅ Test mapping hoàn thành!");
        $this->line("");
        $this->info("💡 Các trạng thái hệ thống:");
        $this->line("   pending        - Chờ xử lý");
        $this->line("   processing     - Đang xử lý");
        $this->line("   shipping       - Đang vận chuyển");
        $this->line("   delivered      - Đã giao hàng");
        $this->line("   delivery_failed - Giao hàng thất bại");
        $this->line("   returning      - Chờ trả hàng");
        $this->line("   returned       - Đã trả hàng");
        $this->line("   exception      - Ngoại lệ");
        $this->line("   cancelled      - Đã hủy");
        $this->line("   lost           - Mất hàng");
        $this->line("   damaged        - Hàng hỏng");
        $this->line("   unknown        - Không xác định");
    }
}