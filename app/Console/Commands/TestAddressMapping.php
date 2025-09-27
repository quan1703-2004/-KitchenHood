<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Address;
use App\Services\AddressMappingService;

class TestAddressMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:address-mapping {--address-id= : ID địa chỉ cụ thể}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test AddressMappingService với địa chỉ thực tế';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test AddressMappingService...');
        
        $mappingService = new AddressMappingService();
        
        if ($this->option('address-id')) {
            $address = Address::find($this->option('address-id'));
            if (!$address) {
                $this->error("❌ Không tìm thấy địa chỉ với ID: {$this->option('address-id')}");
                return;
            }
            $this->testAddress($mappingService, $address);
        } else {
            $addresses = Address::all();
            $this->info("📋 Tìm thấy {$addresses->count()} địa chỉ trong hệ thống");
            
            foreach ($addresses as $address) {
                $this->testAddress($mappingService, $address);
                $this->newLine();
            }
        }
    }
    
    private function testAddress(AddressMappingService $mappingService, Address $address)
    {
        $this->info("📍 Địa chỉ ID: {$address->id}");
        $this->info("🏠 Địa chỉ: {$address->full_address}");
        $this->info("🏢 Province: {$address->province_name} (ID: {$address->province_id})");
        $this->info("🏘️ District: {$address->district_name} (ID: {$address->district_id})");
        $this->info("🏘️ Ward: {$address->ward_name} (ID: {$address->ward_id})");
        
        $this->info("🔍 Đang convert địa chỉ sang GHN format...");
        $result = $mappingService->convertAddressToGhn($address);
        
        if ($result['success']) {
            $this->info("✅ Convert thành công!");
            $this->info("🏢 GHN Province ID: {$result['ghn_province_id']}");
            $this->info("🏘️ GHN District ID: {$result['ghn_district_id']}");
            $this->info("🏘️ GHN Ward Code: {$result['ghn_ward_code']}");
            
            // Test tạo đơn hàng GHN với địa chỉ đã convert
            $this->info("🚚 Test tạo đơn hàng GHN với địa chỉ đã convert...");
            $this->testGhnOrderCreation($result);
            
        } else {
            $this->error("❌ Convert thất bại: {$result['error']}");
        }
    }
    
    private function testGhnOrderCreation($addressData)
    {
        try {
            $ghnService = new \App\Services\GhnService();
            
            $testOrderData = [
                'order_id' => 999,
                'order_number' => 'TEST-MAPPING-' . date('YmdHis'),
                'shipping_name' => $addressData['mapped_address']['full_name'],
                'shipping_phone' => $addressData['mapped_address']['phone'],
                'shipping_address' => $addressData['mapped_address']['street_address'],
                'shipping_district_id' => $addressData['ghn_district_id'],
                'shipping_ward_code' => $addressData['ghn_ward_code'],
                'total_amount' => 100000,
                'notes' => 'Test order với địa chỉ đã convert',
                'items' => [
                    [
                        'product_id' => 1,
                        'product_name' => 'Test Product',
                        'product_price' => 100000,
                        'quantity' => 1
                    ]
                ]
            ];
            
            $ghnResult = $ghnService->createShippingOrder($testOrderData);
            
            if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                $this->info("🎉 Tạo đơn hàng GHN thành công!");
                $this->info("📋 GHN Order Code: {$ghnResult['data']['order_code']}");
            } else {
                $this->warn("⚠️ Tạo đơn hàng GHN thất bại");
                $this->line("Response: " . json_encode($ghnResult));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi test GHN: " . $e->getMessage());
        }
    }
}