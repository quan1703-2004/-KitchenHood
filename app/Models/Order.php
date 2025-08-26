<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'payment_method',
        'notes',
        'status',
        'total_amount',
        'shipping_fee',
        'final_amount'
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'shipping_fee' => 'integer',
        'final_amount' => 'integer'
    ];

    /**
     * Quan hệ với các mục đơn hàng
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Lấy trạng thái đơn hàng dạng text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã giao hàng',
            'delivered' => 'Đã nhận hàng',
            'cancelled' => 'Đã hủy'
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
            'bank_transfer' => 'Chuyển khoản ngân hàng'
        ];

        return $methods[$this->payment_method] ?? 'Không xác định';
    }

    /**
     * Format số tiền
     */
    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount) . ' VNĐ';
    }

    public function getFormattedShippingFeeAttribute()
    {
        return number_format($this->shipping_fee) . ' VNĐ';
    }

    public function getFormattedFinalAmountAttribute()
    {
        return number_format($this->final_amount) . ' VNĐ';
    }
}
