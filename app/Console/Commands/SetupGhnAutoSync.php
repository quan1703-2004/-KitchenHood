<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncOrderStatusFromGhnJob;

class SetupGhnAutoSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:setup-auto-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thiết lập tự động đồng bộ trạng thái đơn hàng từ GHN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Thiết lập tự động đồng bộ trạng thái đơn hàng từ GHN...');
        
        // Test đồng bộ trước khi thiết lập
        $this->info('🧪 Test đồng bộ trước khi thiết lập...');
        $this->call('ghn:sync-order-status', ['--all' => true]);
        
        $this->info("\n📋 Hướng dẫn thiết lập cron job:");
        $this->line("");
        $this->info("1. Mở crontab editor:");
        $this->line("   crontab -e");
        $this->line("");
        $this->info("2. Thêm các dòng sau:");
        $this->line("   # Đồng bộ trạng thái đơn hàng từ GHN mỗi 5 phút");
        $this->line("   */5 * * * * cd " . base_path() . " && php artisan ghn:sync-order-status --all >> /dev/null 2>&1");
        $this->line("");
        $this->line("   # Hoặc sử dụng queue (khuyến nghị):");
        $this->line("   */5 * * * * cd " . base_path() . " && php artisan queue:work --once >> /dev/null 2>&1");
        $this->line("");
        $this->info("3. Lưu và thoát crontab editor");
        $this->line("");
        $this->info("📋 Các command có sẵn:");
        $this->line("   php artisan ghn:sync-order-status --all                    # Đồng bộ tất cả");
        $this->line("   php artisan ghn:sync-order-status --order-code=L3A479        # Đồng bộ đơn hàng cụ thể");
        $this->line("   php artisan test:ghn-status-sync                            # Test đồng bộ");
        $this->line("");
        $this->info("📋 Các job có sẵn:");
        $this->line("   SyncOrderStatusFromGhnJob::dispatch()                       # Đồng bộ tất cả");
        $this->line("   SyncOrderStatusFromGhnJob::dispatch('L3A479')              # Đồng bộ đơn hàng cụ thể");
        $this->line("");
        $this->info("✅ Thiết lập hoàn thành!");
    }
}