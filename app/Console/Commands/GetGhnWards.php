<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnService;

class GetGhnWards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:wards {district_id=1442 : District ID để lấy danh sách phường/xã}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lấy danh sách phường/xã từ GHN API theo district_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $districtId = $this->argument('district_id');
        
        $this->info("🔍 Đang lấy danh sách phường/xã cho District ID: {$districtId}...");
        
        $ghnService = new GhnService();
        $wards = $ghnService->getWardsByDistrict($districtId);
        
        if ($wards && isset($wards['data'])) {
            $this->info("✅ Tìm thấy " . count($wards['data']) . " phường/xã:");
            $this->newLine();
            
            $tableData = [];
            foreach ($wards['data'] as $ward) {
                $tableData[] = [
                    $ward['WardCode'],
                    $ward['WardName'],
                    $ward['DistrictID'] ?? 'N/A'
                ];
            }
            
            $this->table(
                ['Ward Code', 'Tên phường/xã', 'District ID'],
                $tableData
            );
            
            $this->newLine();
            $this->info("💡 Sử dụng Ward Code trong file .env:");
            $this->line("GHN_FROM_WARD_CODE=<ward_code_từ_bảng_trên>");
            
        } else {
            $this->error("❌ Không thể lấy danh sách phường/xã");
            $this->line("Response: " . json_encode($wards));
        }
    }
}