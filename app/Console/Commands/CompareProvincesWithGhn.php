<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Address;

class CompareProvincesWithGhn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:provinces-ghn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'So sánh danh sách provinces với GHN API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 So sánh danh sách provinces với GHN API...');
        
        // Lấy provinces từ GHN API
        $this->info('📡 Đang lấy danh sách provinces từ GHN API...');
        $ghnProvinces = $this->getGhnProvinces();
        
        if (!$ghnProvinces) {
            $this->error('❌ Không thể lấy danh sách provinces từ GHN API');
            return;
        }
        
        $this->info("✅ Tìm thấy " . count($ghnProvinces) . " provinces trong GHN API");
        
        // Lấy provinces từ hệ thống hiện tại
        $this->info('📋 Đang lấy danh sách provinces từ hệ thống...');
        $systemProvinces = $this->getSystemProvinces();
        
        $this->info("✅ Tìm thấy " . count($systemProvinces) . " provinces trong hệ thống");
        
        // So sánh
        $this->newLine();
        $this->info('🔍 So sánh provinces...');
        
        $tableData = [];
        foreach ($systemProvinces as $systemProvince) {
            $found = false;
            $ghnMatch = null;
            
            foreach ($ghnProvinces as $ghnProvince) {
                if ($ghnProvince['ProvinceName'] == $systemProvince['name']) {
                    $found = true;
                    $ghnMatch = $ghnProvince;
                    break;
                }
            }
            
            $tableData[] = [
                $systemProvince['id'],
                $systemProvince['name'],
                $found ? '✅' : '❌',
                $found ? $ghnMatch['ProvinceID'] : 'N/A',
                $found ? $ghnMatch['ProvinceName'] : 'Không tìm thấy'
            ];
        }
        
        $this->table(
            ['System ID', 'System Name', 'Match', 'GHN ID', 'GHN Name'],
            $tableData
        );
        
        // Hiển thị provinces chỉ có trong GHN
        $this->newLine();
        $this->info('📋 Provinces chỉ có trong GHN API:');
        foreach ($ghnProvinces as $ghnProvince) {
            $found = false;
            foreach ($systemProvinces as $systemProvince) {
                if ($ghnProvince['ProvinceName'] == $systemProvince['name']) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $this->line("  - {$ghnProvince['ProvinceName']} (ID: {$ghnProvince['ProvinceID']})");
            }
        }
    }
    
    private function getGhnProvinces()
    {
        try {
            $response = \Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => config('services.ghn.token'),
            ])->timeout(30)->get(config('services.ghn.api_url') . '/shiip/public-api/master-data/province');
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    private function getSystemProvinces()
    {
        try {
            $response = file_get_contents('https://esgoo.net/api-tinhthanh/1/0.htm');
            $data = json_decode($response, true);
            
            if ($data && $data['error'] == 0) {
                return $data['data'];
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}