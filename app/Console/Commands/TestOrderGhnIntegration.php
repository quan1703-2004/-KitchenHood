<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\AddressMappingService;
use App\Services\GhnService;

class TestOrderGhnIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:order-ghn-integration {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test GHN integration với đơn hàng thực tế';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        $this->info("🧪 Test GHN integration với đơn hàng ID: {$orderId}");
        
        $order = Order::find($orderId);
        if (!$order) {
            $this->error("❌ Không tìm thấy đơn hàng với ID: {$orderId}");
            return;
        }
        
        $this->info("📋 Order: {$order->order_number}");
        $this->info("📍 Address: {$order->shipping_address}");
        $this->info("🏢 Province: {$order->shipping_province_name} (ID: {$order->shipping_province_id})");
        $this->info("🏘️ District: {$order->shipping_district_name} (ID: {$order->shipping_district_id})");
        $this->info("🏘️ Ward: {$order->shipping_ward_name} (ID: {$order->shipping_ward_id})");
        
        // Test AddressMappingService với Order object
        $this->info("🔍 Test AddressMappingService với Order object...");
        $mappingService = new AddressMappingService();
        
        try {
            $addressMapping = $mappingService->convertAddressToGhn($order);
            
            if ($addressMapping['success']) {
                $this->info("✅ Address mapping thành công!");
                $this->info("🏢 GHN Province ID: {$addressMapping['ghn_province_id']}");
                $this->info("🏘️ GHN District ID: {$addressMapping['ghn_district_id']}");
                $this->info("🏘️ GHN Ward Code: {$addressMapping['ghn_ward_code']}");
                
                // Test GHN API call
                $this->info("🚚 Test GHN API call...");
                $ghnService = new GhnService();
                
                $orderData = [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'shipping_name' => $order->shipping_name,
                    'shipping_phone' => $order->shipping_phone,
                    'shipping_address' => $order->shipping_address,
                    'shipping_district_id' => $addressMapping['ghn_district_id'],
                    'shipping_ward_code' => $addressMapping['ghn_ward_code'],
                    'total_amount' => $order->total_amount,
                    'notes' => $order->notes,
                    'items' => [
                        [
                            'product_id' => 1,
                            'product_name' => 'Test Product',
                            'product_price' => $order->total_amount,
                            'quantity' => 1
                        ]
                    ]
                ];
                
                $ghnResult = $ghnService->createShippingOrder($orderData);
                
                if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                    $this->info("🎉 GHN API call thành công!");
                    $this->info("📋 GHN Order Code: {$ghnResult['data']['order_code']}");
                    
                    // Cập nhật order_code
                    $order->order_code = $ghnResult['data']['order_code'];
                    $order->save();
                    $this->info("✅ Đã cập nhật order_code vào database!");
                    
                } else {
                    $this->error("❌ GHN API call thất bại!");
                    $this->line("Response: " . json_encode($ghnResult));
                }
                
            } else {
                $this->error("❌ Address mapping thất bại: {$addressMapping['error']}");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            $this->line("Trace: " . $e->getTraceAsString());
        }
    }
}