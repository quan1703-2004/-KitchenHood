<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal'
    ];

    protected $casts = [
        'product_price' => 'integer',
        'quantity' => 'integer',
        'subtotal' => 'integer'
    ];

    /**
     * Quan hệ với đơn hàng
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ với sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Format số tiền
     */
    public function getFormattedProductPriceAttribute()
    {
        return number_format($this->product_price) . ' VNĐ';
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal) . ' VNĐ';
    }
}
