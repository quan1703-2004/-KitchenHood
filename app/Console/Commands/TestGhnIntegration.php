<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnServiceTest;

class TestGhnIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:test {--connection : Chỉ test kết nối} {--order : Chỉ test tạo đơn hàng}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test tích hợp GHN API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Bắt đầu test tích hợp GHN API...');
        $this->newLine();

        $testService = new GhnServiceTest();

        // Test kết nối
        if (!$this->option('order')) {
            $this->info('📡 Test kết nối GHN API...');
            $connectionResult = $testService->testConnection();
            
            if ($connectionResult['success']) {
                $this->info('✅ ' . $connectionResult['message']);
                if (isset($connectionResult['provinces_count'])) {
                    $this->info('📊 Số tỉnh thành có sẵn: ' . $connectionResult['provinces_count']);
                }
            } else {
                $this->error('❌ ' . $connectionResult['message']);
                if (isset($connectionResult['response'])) {
                    $this->line('Response: ' . $connectionResult['response']);
                }
            }
            $this->newLine();
        }

        // Test tạo đơn hàng
        if (!$this->option('connection')) {
            $this->info('📦 Test tạo đơn hàng GHN...');
            $orderResult = $testService->testCreateOrder();
            
            if ($orderResult['success']) {
                $this->info('✅ ' . $orderResult['message']);
                if (isset($orderResult['order_code'])) {
                    $this->info('📋 Mã đơn hàng GHN: ' . $orderResult['order_code']);
                }
            } else {
                $this->error('❌ ' . $orderResult['message']);
                if (isset($orderResult['response'])) {
                    $this->line('Response: ' . $orderResult['response']);
                }
            }
        }

        $this->newLine();
        $this->info('🏁 Hoàn thành test tích hợp GHN API!');
        
        // Hướng dẫn cấu hình nếu có lỗi
        if ((!$this->option('order') && !$connectionResult['success']) || 
            (!$this->option('connection') && !$orderResult['success'])) {
            $this->newLine();
            $this->warn('💡 Hướng dẫn cấu hình:');
            $this->line('1. Thêm các biến môi trường GHN vào file .env');
            $this->line('2. Xem file GHN_INTEGRATION_GUIDE.md để biết chi tiết');
            $this->line('3. Chạy lại lệnh: php artisan ghn:test');
        }
    }
}