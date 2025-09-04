<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'notes',
        'user_id',
        'order_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer'
    ];

    /**
     * Quan hệ với sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ với người dùng thực hiện
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với đơn hàng (nếu xuất hàng)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Lấy loại giao dịch dạng text
     */
    public function getTypeTextAttribute()
    {
        return $this->type === 'in' ? 'Nhập hàng' : 'Xuất hàng';
    }

    /**
     * Lấy tên người thực hiện
     */
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'Hệ thống';
    }

    /**
     * Scope lấy giao dịch nhập hàng
     */
    public function scopeIncoming($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope lấy giao dịch xuất hàng
     */
    public function scopeOutgoing($query)
    {
        return $query->where('type', 'out');
    }

    /**
     * Scope lấy giao dịch theo sản phẩm
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
