<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'order_code', // Mã đơn hàng từ GHN API
        'status',
        'subtotal',
        'shipping_fee',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_province_id',
        'shipping_province_name',
        'shipping_district_id',
        'shipping_district_name',
        'shipping_ward_id',
        'shipping_ward_name',
        'shipping_ward_code', // Mã phường/xã cho GHN
        'notes',
        'momo_request_id',
        'momo_order_id',
        'rating',
        'review_comment',
        'reviewed_at'
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'shipping_fee' => 'integer',
        'discount_amount' => 'integer',
        'total_amount' => 'integer',
        'rating' => 'integer',
        'reviewed_at' => 'datetime'
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với OrderItems
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship với OrderHistory
     */
    public function orderHistories(): HasMany
    {
        return $this->hasMany(OrderHistory::class);
    }

    /**
     * Lấy trạng thái đơn hàng dạng text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'waiting_payment' => 'Chờ thanh toán',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'delivery_failed' => 'Giao hàng thất bại',
            'returning' => 'Đang trả hàng',
            'returned' => 'Đã trả hàng',
            'exception' => 'Ngoại lệ',
            'cancelled' => 'Đã hủy',
            'lost' => 'Mất hàng',
            'damaged' => 'Hàng hỏng',
            'unknown' => 'Không xác định'
        ];

        return $statuses[$this->status] ?? 'Không xác định';
    }

    /**
     * Lấy phương thức thanh toán dạng text
     */
    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'cod' => 'Thanh toán khi nhận hàng (COD)',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo'
        ];

        return $methods[$this->payment_method] ?? 'Không xác định';
    }

    // quan hệ với OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    /**
     * Lấy trạng thái thanh toán dạng text
     */
    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền'
        ];

        return $statuses[$this->payment_status] ?? 'Không xác định';
    }

    /**
     * Format số tiền
     */
    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal) . ' VNĐ';
    }

    public function getFormattedShippingFeeAttribute()
    {
        return number_format($this->shipping_fee) . ' VNĐ';
    }

    public function getFormattedDiscountAmountAttribute()
    {
        return number_format($this->discount_amount) . ' VNĐ';
    }

    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount) . ' VNĐ';
    }

    /**
     * Lấy địa chỉ giao hàng đầy đủ
     */
    public function getFullShippingAddressAttribute()
    {
        $address = $this->shipping_address;
        if ($this->shipping_ward_name) {
            $address .= ', ' . $this->shipping_ward_name;
        }
        if ($this->shipping_district_name) {
            $address .= ', ' . $this->shipping_district_name;
        }
        if ($this->shipping_province_name) {
            $address .= ', ' . $this->shipping_province_name;
        }
        return $address;
    }

    /**
     * Scope để lấy đơn hàng theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lấy đơn hàng đã giao
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope để lấy đơn hàng chưa đánh giá
     */
    public function scopeNotReviewed($query)
    {
        return $query->whereNull('reviewed_at');
    }
    /**
     * Kiểm tra đơn hàng đã có mã GHN chưa
     */
    public function hasGhnOrderCode(): bool
    {
        return !empty($this->order_code);
    }

    /**
     * Lấy mã đơn hàng GHN hoặc thông báo chưa có
     */
    public function getGhnOrderCodeAttribute($value)
    {
        return !empty($value) ? $value : 'Chưa có mã GHN';
    }
}
