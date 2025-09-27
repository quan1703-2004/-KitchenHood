<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\GhnOrderStatusSyncService;
use Illuminate\Support\Facades\Log;

class SyncOrderStatusFromGhnJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderCode;
    protected $syncAll;

    /**
     * Create a new job instance.
     */
    public function __construct(string $orderCode = null, bool $syncAll = false)
    {
        $this->orderCode = $orderCode;
        $this->syncAll = $syncAll;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $syncService = new GhnOrderStatusSyncService();
        
        try {
            if ($this->syncAll) {
                Log::info('GHN Sync Job - Bắt đầu đồng bộ tất cả đơn hàng');
                $results = $syncService->syncAllOrdersWithGhnCode();
                
                Log::info('GHN Sync Job - Kết quả đồng bộ', [
                    'total' => $results['total'],
                    'success' => $results['success'],
                    'failed' => $results['failed'],
                    'updated' => $results['updated']
                ]);
            } elseif ($this->orderCode) {
                Log::info('GHN Sync Job - Đồng bộ đơn hàng', ['order_code' => $this->orderCode]);
                $result = $syncService->syncOrderStatus($this->orderCode);
                
                if ($result['success']) {
                    Log::info('GHN Sync Job - Đồng bộ thành công', [
                        'order_code' => $this->orderCode,
                        'ghn_status' => $result['ghn_status'],
                        'system_status' => $result['system_status']
                    ]);
                } else {
                    Log::error('GHN Sync Job - Đồng bộ thất bại', [
                        'order_code' => $this->orderCode,
                        'error' => $result['error']
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('GHN Sync Job - Exception', [
                'order_code' => $this->orderCode,
                'sync_all' => $this->syncAll,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('GHN Sync Job - Failed', [
            'order_code' => $this->orderCode,
            'sync_all' => $this->syncAll,
            'error' => $exception->getMessage()
        ]);
    }
}