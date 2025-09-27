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
        'email_verified_at',
        'avatar',
        'phone',
        'birth_date',
        'gender',
        'address',
        'google_id',
        'facebook_id',
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
            'birth_date' => 'date',
        ];
    }

    /**
     * Get the avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        return asset('images/avatars/default-avatar.svg');
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
     * Relationship với Review - một user có thể có nhiều đánh giá
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship với Favorite - một user có thể yêu thích nhiều sản phẩm
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Lấy danh sách sản phẩm yêu thích của user
     */
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites')
                    ->withTimestamps()
                    ->orderBy('favorites.created_at', 'desc');
    }

    /**
     * Kiểm tra xem user có yêu thích sản phẩm này không
     */
    public function isFavorite($productId)
    {
        return $this->favorites()->where('product_id', $productId)->exists();
    }

    /**
     * Relationship với Cart - một user có một giỏ hàng
     */
    /**
     * Quan hệ với Cart (singular - trả về cart đầu tiên)
     */
    public function cart()
    {
        return $this->hasOne(Cart::class)->latest();
    }

    /**
     * Quan hệ với Cart (plural - trả về tất cả carts)
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
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

    /**
     * Relationship với Message - messages sent by this user
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relationship với Message - messages received by this user
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all messages for this user (both sent and received)
     */
    public function messages()
    {
        return Message::where('sender_id', $this->id)
                     ->orWhere('receiver_id', $this->id)
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Get unread messages count for this user
     */
    public function getUnreadMessagesCount()
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    /**
     * Get conversations for this user
     */
    public function getConversations()
    {
        $conversations = Message::select('sender_id', 'receiver_id')
            ->where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id)
            ->groupBy('sender_id', 'receiver_id')
            ->get();

        $userIds = [];
        foreach ($conversations as $conversation) {
            if ($conversation->sender_id != $this->id) {
                $userIds[] = $conversation->sender_id;
            }
            if ($conversation->receiver_id != $this->id) {
                $userIds[] = $conversation->receiver_id;
            }
        }

        return User::whereIn('id', array_unique($userIds))->get();
    }

}