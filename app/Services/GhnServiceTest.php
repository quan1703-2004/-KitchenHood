<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GhnServiceTest
{
    /**
     * Test kết nối với GHN API
     * 
     * @return array Kết quả test
     */
    public function testConnection(): array
    {
        $apiUrl = config('services.ghn.api_url');
        $token = config('services.ghn.token');
        
        if (!$token) {
            return [
                'success' => false,
                'message' => 'GHN Token chưa được cấu hình trong file .env'
            ];
        }

        try {
            // Test API bằng cách gọi endpoint lấy danh sách tỉnh thành
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->timeout(10)->get($apiUrl . '/shiip/public-api/master-data/province');

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => 'Kết nối GHN API thành công',
                    'provinces_count' => count($data['data'] ?? [])
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi kết nối GHN API: ' . $response->status(),
                    'response' => $response->body()
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception khi test GHN API: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test tạo đơn hàng mẫu trên GHN
     * 
     * @return array Kết quả test
     */
    public function testCreateOrder(): array
    {
        $apiUrl = config('services.ghn.api_url');
        $token = config('services.ghn.token');
        $shopId = config('services.ghn.shop_id');
        $fromDistrictId = config('services.ghn.from_district_id');
        $fromWardCode = config('services.ghn.from_ward_code');

        // Kiểm tra cấu hình
        $missingConfigs = [];
        if (!$token) $missingConfigs[] = 'GHN_TOKEN';
        if (!$shopId) $missingConfigs[] = 'GHN_SHOP_ID';
        if (!$fromDistrictId) $missingConfigs[] = 'GHN_FROM_DISTRICT_ID';
        if (!$fromWardCode) $missingConfigs[] = 'GHN_FROM_WARD_CODE';

        if (!empty($missingConfigs)) {
            return [
                'success' => false,
                'message' => 'Thiếu cấu hình: ' . implode(', ', $missingConfigs)
            ];
        }

        try {
            // Sử dụng địa chỉ thực tế từ cấu hình
            $fromDistrictId = config('services.ghn.from_district_id');
            $fromWardCode = config('services.ghn.from_ward_code');
            $toDistrictId = 1442; // Quận 1, TP.HCM
            $toWardCode = '20101'; // Phường Bến Nghé, Quận 1 (ward code hợp lệ)
            
            // Dữ liệu đơn hàng test với đầy đủ thông tin from và to
            $testOrderData = [
                'payment_type_id' => 2, // COD
                'note' => 'Test order from Laravel',
                'required_note' => 'KHONGCHOXEMHANG',
                'from_name' => 'Kitchen Hood Store',
                'from_phone' => '0352135115',
                'from_address' => '110 Nguyễn Huệ, Bến Nghé, Quận 1, Hồ Chí Minh',
                'from_district_id' => $fromDistrictId,
                'from_ward_code' => $fromWardCode,
                'to_name' => 'Nguyễn Văn Test',
                'to_phone' => '0352135115',
                'to_address' => '110 Nguyễn Huệ, Bến Nghé, Quận 1, Hồ Chí Minh, Việt Nam',
                'to_ward_code' => $toWardCode,
                'to_district_id' => $toDistrictId,
                'cod_amount' => 100000,
                'content' => 'TEST-ORDER-' . date('YmdHis'),
                'weight' => 100,
                'length' => 20,
                'width' => 20,
                'height' => 20,
                'service_type_id' => 2,
                'service_id' => 0,
                'items' => [
                    [
                        'name' => 'Sản phẩm test',
                        'code' => 'SP001',
                        'quantity' => 1,
                        'price' => 100000,
                        'weight' => 100
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->timeout(30)->post($apiUrl . '/shiip/public-api/v2/shipping-order/create', $testOrderData);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => 'Test tạo đơn hàng GHN thành công',
                    'order_code' => $data['data']['order_code'] ?? null,
                    'response' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi tạo đơn hàng GHN: ' . $response->status(),
                    'response' => $response->body()
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception khi test tạo đơn hàng GHN: ' . $e->getMessage()
            ];
        }
    }
}