<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnOrderStatusSyncService;
use App\Services\GhnService;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class TestGhnSyncDebug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:debug {--test-api} {--test-sync} {--check-config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug và test hệ thống đồng bộ GHN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 GHN Debug Tool");
        $this->line("");

        if ($this->option('check-config')) {
            $this->checkConfiguration();
        }

        if ($this->option('test-api')) {
            $this->testGhnApi();
        }

        if ($this->option('test-sync')) {
            $this->testSyncService();
        }

        if (!$this->option('check-config') && !$this->option('test-api') && !$this->option('test-sync')) {
            $this->showHelp();
        }
    }

    /**
     * Kiểm tra cấu hình GHN
     */
    private function checkConfiguration(): void
    {
        $this->info("📋 Kiểm tra cấu hình GHN:");
        
        $configs = [
            'GHN_API_URL' => config('services.ghn.api_url'),
            'GHN_TOKEN' => config('services.ghn.token') ? '***' . substr(config('services.ghn.token'), -4) : 'NULL',
            'GHN_SHOP_ID' => config('services.ghn.shop_id'),
            'GHN_FROM_DISTRICT_ID' => config('services.ghn.from_district_id'),
            'GHN_FROM_WARD_CODE' => config('services.ghn.from_ward_code'),
        ];

        foreach ($configs as $key => $value) {
            $status = $value ? '✅' : '❌';
            $this->line("   {$status} {$key}: " . ($value ?: 'NULL'));
        }

        $this->line("");
    }

    /**
     * Test GHN API
     */
    private function testGhnApi(): void
    {
        $this->info("🌐 Test GHN API:");
        
        try {
            $ghnService = new GhnService();
            
            // Test lấy danh sách phường/xã
            $this->line("   🔍 Test lấy danh sách phường/xã...");
            $wards = $ghnService->getWardsByDistrict(1542); // Quận 1, HCM
            
            if ($wards && isset($wards['data'])) {
                $this->info("   ✅ API hoạt động bình thường");
                $this->line("   📊 Số lượng phường/xã: " . count($wards['data']));
            } else {
                $this->error("   ❌ API không trả về dữ liệu");
            }
            
        } catch (\Exception $e) {
            $this->error("   ❌ Lỗi API: " . $e->getMessage());
        }

        $this->line("");
    }

    /**
     * Test Sync Service
     */
    private function testSyncService(): void
    {
        $this->info("🔄 Test Sync Service:");
        
        try {
            $syncService = new GhnOrderStatusSyncService();
            
            // Kiểm tra đơn hàng có mã GHN
            $ordersWithGhnCode = Order::whereNotNull('order_code')
                                   ->where('order_code', '<>', '')
                                   ->count();
            
            $this->line("   📊 Số đơn hàng có mã GHN: {$ordersWithGhnCode}");
            
            if ($ordersWithGhnCode > 0) {
                $this->line("   🔍 Test đồng bộ một đơn hàng...");
                
                $sampleOrder = Order::whereNotNull('order_code')
                                  ->where('order_code', '<>', '')
                                  ->first();
                
                if ($sampleOrder) {
                    $this->line("   📋 Đơn hàng test: {$sampleOrder->order_number} ({$sampleOrder->order_code})");
                    
                    $result = $syncService->syncOrderStatus($sampleOrder->order_code);
                    
                    if ($result['success']) {
                        $this->info("   ✅ Đồng bộ thành công");
                        $this->line("   📊 Trạng thái GHN: {$result['ghn_status']}");
                        $this->line("   📊 Trạng thái hệ thống: {$result['system_status']}");
                    } else {
                        $this->error("   ❌ Đồng bộ thất bại: {$result['error']}");
                    }
                }
            } else {
                $this->warn("   ⚠️ Không có đơn hàng nào có mã GHN để test");
            }
            
        } catch (\Exception $e) {
            $this->error("   ❌ Lỗi Sync Service: " . $e->getMessage());
        }

        $this->line("");
    }

    /**
     * Hiển thị hướng dẫn sử dụng
     */
    private function showHelp(): void
    {
        $this->info("🔍 GHN Debug Tool");
        $this->line("");
        $this->info("Cách sử dụng:");
        $this->line("  php artisan ghn:debug --check-config    Kiểm tra cấu hình");
        $this->line("  php artisan ghn:debug --test-api        Test GHN API");
        $this->line("  php artisan ghn:debug --test-sync       Test Sync Service");
        $this->line("  php artisan ghn:debug --check-config --test-api --test-sync  Chạy tất cả");
        $this->line("");
        $this->info("Ví dụ:");
        $this->line("  php artisan ghn:debug --check-config");
        $this->line("  php artisan ghn:debug --test-api");
        $this->line("  php artisan ghn:debug --test-sync");
    }
}