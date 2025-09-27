<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AddressMappingService
{
    private $apiUrl;
    private $token;

    public function __construct()
    {
        $this->apiUrl = config('services.ghn.api_url');
        $this->token = config('services.ghn.token');
    }

    /**
     * Mapping province name từ hệ thống sang GHN API
     */
    private function mapProvinceName($systemProvinceName)
    {
        $mapping = [
            'Thành phố Hà Nội' => 'Hà Nội',
            'Thành phố Hồ Chí Minh' => 'Hồ Chí Minh',
            'Thành phố Đà Nẵng' => 'Đà Nẵng',
            'Thành phố Cần Thơ' => 'Cần Thơ',
            'Tỉnh Hải Phòng' => 'Hải Phòng',
            'Tỉnh Đà Nẵng' => 'Đà Nẵng',
            'Tỉnh Bắc Ninh' => 'Bắc Ninh',
            'Tỉnh Hà Nam' => 'Hà Nam',
            'Tỉnh Hưng Yên' => 'Hưng Yên',
            'Tỉnh Hải Dương' => 'Hải Dương',
            'Tỉnh Thái Bình' => 'Thái Bình',
            'Tỉnh Nam Định' => 'Nam Định',
            'Tỉnh Ninh Bình' => 'Ninh Bình',
            'Tỉnh Thanh Hóa' => 'Thanh Hóa',
            'Tỉnh Nghệ An' => 'Nghệ An',
            'Tỉnh Hà Tĩnh' => 'Hà Tĩnh',
            'Tỉnh Quảng Bình' => 'Quảng Bình',
            'Tỉnh Quảng Trị' => 'Quảng Trị',
            'Tỉnh Thừa Thiên Huế' => 'Thừa Thiên Huế',
            'Tỉnh Quảng Nam' => 'Quảng Nam',
            'Tỉnh Quảng Ngãi' => 'Quảng Ngãi',
            'Tỉnh Bình Định' => 'Bình Định',
            'Tỉnh Phú Yên' => 'Phú Yên',
            'Tỉnh Khánh Hòa' => 'Khánh Hòa',
            'Tỉnh Ninh Thuận' => 'Ninh Thuận',
            'Tỉnh Bình Thuận' => 'Bình Thuận',
            'Tỉnh Kon Tum' => 'Kon Tum',
            'Tỉnh Gia Lai' => 'Gia Lai',
            'Tỉnh Đắk Lắk' => 'Đắk Lắk',
            'Tỉnh Đắk Nông' => 'Đắk Nông',
            'Tỉnh Lâm Đồng' => 'Lâm Đồng',
            'Tỉnh Bình Phước' => 'Bình Phước',
            'Tỉnh Tây Ninh' => 'Tây Ninh',
            'Tỉnh Bình Dương' => 'Bình Dương',
            'Tỉnh Đồng Nai' => 'Đồng Nai',
            'Tỉnh Bà Rịa - Vũng Tàu' => 'Bà Rịa - Vũng Tàu',
            'Tỉnh Long An' => 'Long An',
            'Tỉnh Tiền Giang' => 'Tiền Giang',
            'Tỉnh Bến Tre' => 'Bến Tre',
            'Tỉnh Trà Vinh' => 'Trà Vinh',
            'Tỉnh Vĩnh Long' => 'Vĩnh Long',
            'Tỉnh Đồng Tháp' => 'Đồng Tháp',
            'Tỉnh An Giang' => 'An Giang',
            'Tỉnh Kiên Giang' => 'Kiên Giang',
            'Tỉnh Cà Mau' => 'Cà Mau',
            'Tỉnh Bạc Liêu' => 'Bạc Liêu',
            'Tỉnh Sóc Trăng' => 'Sóc Trăng',
            'Tỉnh Hậu Giang' => 'Hậu Giang',
            'Tỉnh Vĩnh Phúc' => 'Vĩnh Phúc',
            'Tỉnh Thái Nguyên' => 'Thái Nguyên',
            'Tỉnh Lào Cai' => 'Lào Cai',
            'Tỉnh Điện Biên' => 'Điện Biên',
            'Tỉnh Lai Châu' => 'Lai Châu',
            'Tỉnh Sơn La' => 'Sơn La',
            'Tỉnh Yên Bái' => 'Yên Bái',
            'Tỉnh Hoà Bình' => 'Hoà Bình',
            'Tỉnh Thái Nguyên' => 'Thái Nguyên',
            'Tỉnh Lạng Sơn' => 'Lạng Sơn',
            'Tỉnh Quảng Ninh' => 'Quảng Ninh',
            'Tỉnh Bắc Giang' => 'Bắc Giang',
            'Tỉnh Phú Thọ' => 'Phú Thọ',
            'Tỉnh Vĩnh Phúc' => 'Vĩnh Phúc',
            'Tỉnh Bắc Kạn' => 'Bắc Kạn',
            'Tỉnh Tuyên Quang' => 'Tuyên Quang',
            'Tỉnh Cao Bằng' => 'Cao Bằng',
            'Tỉnh Hà Giang' => 'Hà Giang',
            'Tỉnh Bắc Ninh' => 'Bắc Ninh',
            // Thêm các mapping khác nếu cần
        ];

        return $mapping[$systemProvinceName] ?? $systemProvinceName;
    }

    /**
     * Lấy Province ID từ GHN API theo tên
     */
    public function getGhnProvinceId($systemProvinceName)
    {
        try {
            $mappedName = $this->mapProvinceName($systemProvinceName);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $this->token,
            ])->withOptions([
                'verify' => false, // Tắt SSL verification cho development
            ])->timeout(30)->get($this->apiUrl . '/shiip/public-api/master-data/province');

            if ($response->successful()) {
                $data = $response->json();
                $provinces = $data['data'] ?? [];

                foreach ($provinces as $province) {
                    if ($province['ProvinceName'] == $mappedName) {
                        return $province['ProvinceID'];
                    }
                }
            }

            return null;
        } catch (Exception $e) {
            Log::error('Address Mapping - Lỗi lấy Province ID', [
                'province_name' => $systemProvinceName,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Lấy District ID từ GHN API theo tên và Province ID
     */
    public function getGhnDistrictId($systemDistrictName, $ghnProvinceId)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $this->token,
            ])->withOptions([
                'verify' => false, // Tắt SSL verification cho development
            ])->timeout(30)->get($this->apiUrl . '/shiip/public-api/master-data/district', [
                'province_id' => $ghnProvinceId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $districts = $data['data'] ?? [];

                foreach ($districts as $district) {
                    if ($district['DistrictName'] == $systemDistrictName) {
                        return $district['DistrictID'];
                    }
                }
            }

            return null;
        } catch (Exception $e) {
            Log::error('Address Mapping - Lỗi lấy District ID', [
                'district_name' => $systemDistrictName,
                'province_id' => $ghnProvinceId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Lấy Ward Code từ GHN API theo tên và District ID
     */
    public function getGhnWardCode($systemWardName, $ghnDistrictId)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $this->token,
            ])->withOptions([
                'verify' => false, // Tắt SSL verification cho development
            ])->timeout(30)->get($this->apiUrl . '/shiip/public-api/master-data/ward', [
                'district_id' => $ghnDistrictId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $wards = $data['data'] ?? [];

                foreach ($wards as $ward) {
                    if ($ward['WardName'] == $systemWardName) {
                        return $ward['WardCode'];
                    }
                }
            }

            return null;
        } catch (Exception $e) {
            Log::error('Address Mapping - Lỗi lấy Ward Code', [
                'ward_name' => $systemWardName,
                'district_id' => $ghnDistrictId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Convert địa chỉ hệ thống sang GHN format
     */
    public function convertAddressToGhn($systemAddress)
    {
        try {
            // Lấy Province ID từ GHN
            $provinceName = $systemAddress->province_name ?? $systemAddress->shipping_province_name ?? '';
            $ghnProvinceId = $this->getGhnProvinceId($provinceName);
            if (!$ghnProvinceId) {
                return [
                    'success' => false,
                    'error' => "Không tìm thấy Province '{$provinceName}' trong GHN API"
                ];
            }

            // Lấy District ID từ GHN
            $districtName = $systemAddress->district_name ?? $systemAddress->shipping_district_name ?? '';
            $ghnDistrictId = $this->getGhnDistrictId($districtName, $ghnProvinceId);
            if (!$ghnDistrictId) {
                return [
                    'success' => false,
                    'error' => "Không tìm thấy District '{$districtName}' trong GHN API"
                ];
            }

            // Lấy Ward Code từ GHN
            $wardName = $systemAddress->ward_name ?? $systemAddress->shipping_ward_name ?? '';
            $ghnWardCode = $this->getGhnWardCode($wardName, $ghnDistrictId);
            if (!$ghnWardCode) {
                return [
                    'success' => false,
                    'error' => "Không tìm thấy Ward '{$wardName}' trong GHN API"
                ];
            }

            return [
                'success' => true,
                'ghn_province_id' => $ghnProvinceId,
                'ghn_district_id' => $ghnDistrictId,
                'ghn_ward_code' => $ghnWardCode,
                'original_address' => $systemAddress,
                'mapped_address' => [
                    'province_name' => $provinceName,
                    'district_name' => $districtName,
                    'ward_name' => $wardName,
                    'street_address' => $systemAddress->street_address ?? $systemAddress->shipping_address ?? '',
                    'full_name' => $systemAddress->full_name ?? $systemAddress->shipping_name ?? '',
                    'phone' => $systemAddress->phone ?? $systemAddress->shipping_phone ?? ''
                ]
            ];

        } catch (Exception $e) {
            Log::error('Address Mapping - Lỗi convert địa chỉ', [
                'address_id' => $systemAddress->id ?? null,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Lỗi hệ thống khi convert địa chỉ: ' . $e->getMessage()
            ];
        }
    }
}