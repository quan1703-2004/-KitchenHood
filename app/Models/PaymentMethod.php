<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'type',
        'name',
        'description',
        'qr_code_image',
        'bank_name',
        'account_number',
        'account_name',
        'momo_phone',
        'momo_name',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope để lấy các phương thức thanh toán đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope để sắp xếp theo thứ tự
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Kiểm tra xem có phải QR Code không
    public function isQrCode()
    {
        return $this->type === 'qr_code';
    }

    // Kiểm tra xem có phải Momo không
    public function isMomo()
    {
        return $this->type === 'momo';
    }

    // Lấy đường dẫn ảnh QR Code
    public function getQrCodeImageUrlAttribute()
    {
        if ($this->qr_code_image) {
            return asset('storage/' . $this->qr_code_image);
        }
        return null;
    }
}
