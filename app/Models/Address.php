<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'province_id',
        'province_name',
        'district_id', 
        'district_name',
        'ward_id',
        'ward_name',
        'street_address',
        'postal_code',
        'is_default',
        'note'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope để lấy địa chỉ mặc định của user
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope để lấy địa chỉ theo user_id
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Lấy địa chỉ đầy đủ
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->street_address;
        if ($this->ward_name) {
            $address .= ', ' . $this->ward_name;
        }
        if ($this->district_name) {
            $address .= ', ' . $this->district_name;
        }
        if ($this->province_name) {
            $address .= ', ' . $this->province_name;
        }
        return $address;
    }

    /**
     * Lấy địa chỉ ngắn gọn (chỉ tên)
     */
    public function getShortAddressAttribute(): string
    {
        $address = '';
        if ($this->ward_name) {
            $address .= $this->ward_name;
        }
        if ($this->district_name) {
            $address .= $address ? ', ' . $this->district_name : $this->district_name;
        }
        if ($this->province_name) {
            $address .= $address ? ', ' . $this->province_name : $this->province_name;
        }
        return $address ?: 'Chưa có thông tin địa chỉ';
    }

    /**
     * Kiểm tra xem địa chỉ có đầy đủ thông tin không
     */
    public function hasCompleteAddress(): bool
    {
        return !empty($this->ward_name) && !empty($this->district_name) && !empty($this->province_name);
    }
}
