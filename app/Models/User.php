<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship với Address - một user có thể có nhiều địa chỉ
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Lấy địa chỉ mặc định của user
     */
    public function getDefaultAddress()
    {
        return $this->addresses()->where('is_default', true)->first();
    }

    /**
     * Relationship với Order - một user có thể có nhiều đơn hàng
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship với Cart - một user có thể có một giỏ hàng
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Kiểm tra xem user có phải là admin không
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor để tương thích với code cũ
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    // quan hệ review của user
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}