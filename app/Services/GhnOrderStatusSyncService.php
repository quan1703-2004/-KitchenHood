<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GhnOrderStatusSyncService
{
    private $apiUrl;
    private $token;
    private $shopId;

    public function __construct()
    {
        $this->apiUrl = config('services.ghn.api_url');
        $this->token = config('services.ghn.token');
        $this->shopId = config('services.ghn.shop_id');
    }

    /**
     * Đồng bộ trạng thái đơn hàng từ GHN API
     */
    public function syncOrderStatus(string $ghnOrderCode): array
    {
        try {
            $response = Http::withHeaders([
                'Token' => $this->token,
                'Content-Type' => 'application/json'
            ])->withOptions([
                'verify' => false, // Tắt SSL verification cho development
            ])->get($this->apiUrl . '/shiip/public-api/v2/shipping-order/detail', [
                'order_code' => $ghnOrderCode
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['code'] === 200) {
                    $orderData = $data['data'];
                    $ghnStatus = $orderData['status'];
                    
                    // Map GHN status sang hệ thống
                    $systemStatus = $this->mapGhnStatusToSystem($ghnStatus);
                    
                    Log::info('GHN Order Status Sync', [
                        'ghn_order_code' => $ghnOrderCode,
                        'ghn_status' => $ghnStatus,
                        'system_status' => $systemStatus,
                        'order_data' => $orderData
                    ]);

                    return [
                        'success' => true,
                        'ghn_status' => $ghnStatus,
                        'system_status' => $systemStatus,
                        'order_data' => $orderData
                    ];
                } else {
                    Log::error('GHN API Error', [
                        'ghn_order_code' => $ghnOrderCode,
                        'error' => $data['message'] ?? 'Unknown error'
                    ]);
                    
                    return [
                        'success' => false,
                        'error' => $data['message'] ?? 'Unknown error'
                    ];
                }
            } else {
                Log::error('GHN API HTTP Error', [
                    'ghn_order_code' => $ghnOrderCode,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'error' => 'HTTP Error: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('GHN Order Status Sync Exception', [
                'ghn_order_code' => $ghnOrderCode,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Map trạng thái GHN sang trạng thái hệ thống
     */
    private function mapGhnStatusToSystem(string $ghnStatus): string
    {
        $statusMap = [
            'ready_to_pick' => 'pending',           // Sẵn sàng lấy hàng
            'picking' => 'processing',              // Đang lấy hàng
            'picked' => 'processing',              // Đã lấy hàng
            'storing' => 'processing',              // Đang lưu kho
            'transporting' => 'shipping',           // Đang vận chuyển
            'sorting' => 'shipping',                // Đang phân loại
            'delivering' => 'shipping',             // Đang giao hàng
            'delivered' => 'delivered',             // Đã giao hàng
            'delivery_failed' => 'delivery_failed', // Giao hàng thất bại
            'waiting_to_return' => 'returning',     // Chờ trả hàng
            'return' => 'returned',                 // Đã trả hàng
            'returned' => 'returned',               // Đã trả hàng
            'exception' => 'exception',             // Ngoại lệ
            'cancel' => 'cancelled',                // Đã hủy
            'lost' => 'lost',                       // Mất hàng
            'damage' => 'damaged'                   // Hàng hỏng
        ];

        return $statusMap[$ghnStatus] ?? 'unknown';
    }

    /**
     * Cập nhật trạng thái đơn hàng trong hệ thống
     */
    public function updateOrderStatus(Order $order, string $newStatus): bool
    {
        try {
            $oldStatus = $order->status;
            
            $order->update(['status' => $newStatus]);
            
            // Tạo lịch sử thay đổi trạng thái
            $this->createStatusHistory($order, $oldStatus, $newStatus);
            
            Log::info('Order Status Updated', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'ghn_order_code' => $order->order_code,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Order Status Update Failed', [
                'order_id' => $order->id,
                'new_status' => $newStatus,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Tạo lịch sử thay đổi trạng thái
     */
    private function createStatusHistory(Order $order, string $oldStatus, string $newStatus): void
    {
        try {
            $order->orderHistories()->create([
                'status' => $newStatus,
                'note' => "Trạng thái thay đổi từ '{$oldStatus}' sang '{$newStatus}' (đồng bộ từ GHN)",
                'created_by' => 'system'
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to create status history', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Đồng bộ tất cả đơn hàng có mã GHN
     */
    public function syncAllOrdersWithGhnCode(): array
    {
        $orders = Order::whereNotNull('order_code')
                      ->where('order_code', '<>', '')
                      ->where('status', '!=', 'delivered')
                      ->where('status', '!=', 'cancelled')
                      ->where('status', '!=', 'returned')
                      ->get();

        $results = [
            'total' => $orders->count(),
            'success' => 0,
            'failed' => 0,
            'updated' => 0,
            'details' => []
        ];

        foreach ($orders as $order) {
            $oldStatus = $order->status; // Lưu trạng thái cũ trước khi sync
            $syncResult = $this->syncOrderStatus($order->order_code);
            
            if ($syncResult['success']) {
                $results['success']++;
                
                // Kiểm tra xem có cần cập nhật trạng thái không
                if ($syncResult['system_status'] !== $oldStatus) {
                    if ($this->updateOrderStatus($order, $syncResult['system_status'])) {
                        $results['updated']++;
                        $results['details'][] = [
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'ghn_order_code' => $order->order_code,
                            'old_status' => $oldStatus,
                            'new_status' => $syncResult['system_status'],
                            'action' => 'updated'
                        ];
                    }
                } else {
                    $results['details'][] = [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'ghn_order_code' => $order->order_code,
                        'status' => $oldStatus,
                        'action' => 'no_change'
                    ];
                }
            } else {
                $results['failed']++;
                $results['details'][] = [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'ghn_order_code' => $order->order_code,
                    'error' => $syncResult['error'],
                    'action' => 'failed'
                ];
            }
        }

        return $results;
    }

    /**
     * Lấy danh sách trạng thái GHN
     */
    public function getGhnStatusList(): array
    {
        return [
            'ready_to_pick' => 'Sẵn sàng lấy hàng',
            'picking' => 'Đang lấy hàng',
            'picked' => 'Đã lấy hàng',
            'storing' => 'Đang lưu kho',
            'transporting' => 'Đang vận chuyển',
            'sorting' => 'Đang phân loại',
            'delivering' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'delivery_failed' => 'Giao hàng thất bại',
            'waiting_to_return' => 'Chờ trả hàng',
            'return' => 'Đã trả hàng',
            'returned' => 'Đã trả hàng',
            'exception' => 'Ngoại lệ',
            'cancel' => 'Đã hủy',
            'lost' => 'Mất hàng',
            'damage' => 'Hàng hỏng'
        ];
    }
}