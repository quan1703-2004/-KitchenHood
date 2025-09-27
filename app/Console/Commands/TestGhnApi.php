<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GhnService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestGhnApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ghn:test-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test GHN API connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 Testing GHN API Connection...");
        
        // Test cấu hình
        $this->line("📋 Configuration:");
        $this->line("   API URL: " . config('services.ghn.api_url'));
        $this->line("   Token: " . (config('services.ghn.token') ? '***' . substr(config('services.ghn.token'), -4) : 'NULL'));
        $this->line("   Shop ID: " . config('services.ghn.shop_id'));
        $this->line("");
        
        // Test API trực tiếp
        $this->line("🌐 Testing API directly...");
        
        try {
            $apiUrl = config('services.ghn.api_url');
            $token = config('services.ghn.token');
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->timeout(30)->get($apiUrl . '/shiip/public-api/master-data/ward', [
                'district_id' => 1542
            ]);
            
            $this->line("   Status Code: " . $response->status());
            $this->line("   Response Headers: " . json_encode($response->headers()));
            
            if ($response->successful()) {
                $data = $response->json();
                $this->info("   ✅ API Response successful");
                $this->line("   📊 Response keys: " . json_encode(array_keys($data)));
                
                if (isset($data['data'])) {
                    $this->line("   📊 Number of wards: " . count($data['data']));
                }
                
                if (isset($data['message'])) {
                    $this->line("   📝 Message: " . $data['message']);
                }
                
                if (isset($data['code'])) {
                    $this->line("   🔢 Code: " . $data['code']);
                }
            } else {
                $this->error("   ❌ API Response failed");
                $this->line("   📄 Response body: " . $response->body());
            }
            
        } catch (\Exception $e) {
            $this->error("   ❌ Exception: " . $e->getMessage());
            $this->line("   📍 File: " . $e->getFile() . ":" . $e->getLine());
        }
        
        $this->line("");
        
        // Test qua service
        $this->line("🔧 Testing via GhnService...");
        
        try {
            $service = new GhnService();
            $result = $service->getWardsByDistrict(1542);
            
            if ($result) {
                $this->info("   ✅ Service method successful");
                $this->line("   📊 Result keys: " . json_encode(array_keys($result)));
            } else {
                $this->error("   ❌ Service method returned null");
            }
            
        } catch (\Exception $e) {
            $this->error("   ❌ Service Exception: " . $e->getMessage());
        }
    }
}