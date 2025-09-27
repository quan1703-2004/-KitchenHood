<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Address;
use App\Services\GhnService;

class ValidateAddressWithGhn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:address-ghn {--address-id= : ID địa chỉ cụ thể} {--all : Validate tất cả địa chỉ}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate địa chỉ với GHN API để kiểm tra tính tương thích';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Validate địa chỉ với GHN API...');
        
        $ghnService = new GhnService();
        
        if ($this->option('address-id')) {
            $this->validateSpecificAddress($ghnService, $this->option('address-id'));
        } elseif ($this->option('all')) {
            $this->validateAllAddresses($ghnService);
        } else {
            $this->validateUserAddresses($ghnService);
        }
    }
    
    private function validateSpecificAddress(GhnService $ghnService, $addressId)
    {
        $address = Address::find($addressId);
        if (!$address) {
            $this->error("❌ Không tìm thấy địa chỉ với ID: {$addressId}");
            return;
        }
        
        $this->validateAddress($ghnService, $address);
    }
    
    private function validateAllAddresses(GhnService $ghnService)
    {
        $addresses = Address::all();
        $this->info("📋 Tìm thấy {$addresses->count()} địa chỉ trong hệ thống");
        
        foreach ($addresses as $address) {
            $this->validateAddress($ghnService, $address);
            $this->newLine();
        }
    }
    
    private function validateUserAddresses(GhnService $ghnService)
    {
        $addresses = Address::with('user')->get();
        $this->info("📋 Tìm thấy {$addresses->count()} địa chỉ trong hệ thống");
        
        foreach ($addresses as $address) {
            $this->validateAddress($ghnService, $address);
            $this->newLine();
        }
    }
    
    private function validateAddress(GhnService $ghnService, Address $address)
    {
        $this->info("📍 Địa chỉ ID: {$address->id}");
        $this->info("👤 User: " . ($address->user->name ?? 'N/A') . " (ID: {$address->user_id})");
        $this->info("🏠 Địa chỉ: {$address->full_address}");
        $this->info("🏢 Province: {$address->province_name} (ID: {$address->province_id})");
        $this->info("🏘️ District: {$address->district_name} (ID: {$address->district_id})");
        $this->info("🏘️ Ward: {$address->ward_name} (ID: {$address->ward_id})");
        
        // Test lấy danh sách districts từ GHN
        $this->info("🔍 Kiểm tra District với GHN API...");
        $ghnDistricts = $this->getGhnDistricts($ghnService, $address->province_id);
        
        if ($ghnDistricts) {
            $foundDistrict = null;
            foreach ($ghnDistricts as $district) {
                if ($district['DistrictID'] == $address->district_id) {
                    $foundDistrict = $district;
                    break;
                }
            }
            
            if ($foundDistrict) {
                $this->info("✅ District tìm thấy trong GHN: {$foundDistrict['DistrictName']}");
                
                // Test lấy danh sách wards từ GHN
                $this->info("🔍 Kiểm tra Ward với GHN API...");
                $ghnWards = $ghnService->getWardsByDistrict($address->district_id);
                
                if ($ghnWards && isset($ghnWards['data'])) {
                    $foundWard = null;
                    foreach ($ghnWards['data'] as $ward) {
                        if ($ward['WardCode'] == (string)$address->ward_id) {
                            $foundWard = $ward;
                            break;
                        }
                    }
                    
                    if ($foundWard) {
                        $this->info("✅ Ward tìm thấy trong GHN: {$foundWard['WardName']} (Code: {$foundWard['WardCode']})");
                        $this->info("🎉 Địa chỉ HOÀN TOÀN TƯƠNG THÍCH với GHN API!");
                    } else {
                        $this->warn("⚠️ Ward không tìm thấy trong GHN API");
                        $this->info("📋 Danh sách wards có sẵn trong GHN:");
                        foreach ($ghnWards['data'] as $ward) {
                            $this->line("  - {$ward['WardName']} (Code: {$ward['WardCode']})");
                        }
                    }
                } else {
                    $this->error("❌ Không thể lấy danh sách wards từ GHN API");
                }
            } else {
                $this->warn("⚠️ District không tìm thấy trong GHN API");
                $this->info("📋 Danh sách districts có sẵn trong GHN:");
                foreach ($ghnDistricts as $district) {
                    $this->line("  - {$district['DistrictName']} (ID: {$district['DistrictID']})");
                }
            }
        } else {
            $this->error("❌ Không thể lấy danh sách districts từ GHN API cho Province ID: {$address->province_id}");
        }
    }
    
    private function getGhnDistricts(GhnService $ghnService, $provinceId)
    {
        try {
            $response = \Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => config('services.ghn.token'),
            ])->timeout(30)->get(config('services.ghn.api_url') . '/shiip/public-api/master-data/district', [
                'province_id' => $provinceId
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}