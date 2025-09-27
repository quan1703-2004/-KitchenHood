<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnService;

class TestWardCodeConversion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ward-code {district_id=3} {ward_id=103}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test chuyển đổi ward_id thành ward_code';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $districtId = $this->argument('district_id');
        $wardId = $this->argument('ward_id');
        
        $this->info("🔍 Test chuyển đổi ward_id thành ward_code...");
        $this->info("🏢 District ID: {$districtId}");
        $this->info("🏘️ Ward ID: {$wardId}");
        
        try {
            $ghnService = new GhnService();
            
            // Lấy danh sách wards
            $this->info("📡 Đang lấy danh sách phường/xã...");
            $wards = $ghnService->getWardsByDistrict($districtId);
            
            if ($wards && isset($wards['data'])) {
                $this->info("✅ Tìm thấy " . count($wards['data']) . " phường/xã:");
                
                $foundWard = null;
                foreach ($wards['data'] as $ward) {
                    if (isset($ward['WardCode']) && $ward['WardCode'] == (string)$wardId) {
                        $foundWard = $ward;
                        break;
                    }
                }
                
                if ($foundWard) {
                    $this->info("✅ Tìm thấy ward:");
                    $this->table(
                        ['Thông tin', 'Giá trị'],
                        [
                            ['Ward Code', $foundWard['WardCode']],
                            ['Ward Name', $foundWard['WardName']],
                            ['District ID', $foundWard['DistrictID'] ?? 'N/A']
                        ]
                    );
                    
                    // Test method getWardCodeFromWardId
                    $wardCode = $ghnService->getWardCodeFromWardId($districtId, $wardId);
                    $this->info("🔧 Ward Code từ method: " . ($wardCode ?: 'NULL'));
                    
                } else {
                    $this->warn("⚠️ Không tìm thấy ward với ID: {$wardId}");
                    $this->info("📋 Danh sách wards có sẵn:");
                    $tableData = [];
                    foreach ($wards['data'] as $ward) {
                        $tableData[] = [
                            $ward['WardID'] ?? 'N/A',
                            $ward['WardCode'] ?? 'N/A',
                            $ward['WardName'] ?? 'N/A'
                        ];
                    }
                    $this->table(['Ward ID', 'Ward Code', 'Ward Name'], $tableData);
                }
                
            } else {
                $this->error("❌ Không thể lấy danh sách phường/xã");
                $this->line("Response: " . json_encode($wards));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}