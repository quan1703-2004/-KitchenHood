<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'content',
        'is_answered'
    ];

    protected $casts = [
        'is_answered' => 'boolean',
    ];

    // Đảm bảo accessors xuất hiện trong JSON cho phía admin
    protected $appends = ['category_name'];

    // Danh sách các danh mục có sẵn
    public static function getCategories()
    {
        return [
            'general' => 'Tổng quát',
            'product' => 'Sản phẩm',
            'category' => 'Danh mục',
            'warranty' => 'Bảo hành',
            'shipping' => 'Vận chuyển',
            'payment' => 'Thanh toán',
            'return' => 'Đổi trả',
            'technical' => 'Kỹ thuật',
            'other' => 'Khác'
        ];
    }

    // Lấy tên danh mục
    public function getCategoryNameAttribute()
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? 'Khác';
    }

    /**
     * Quan hệ với User (người hỏi)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với Answers (các câu trả lời)
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Scope: Lấy câu hỏi chưa trả lời
     */
    public function scopeUnanswered($query)
    {
        return $query->where('is_answered', 0);
    }

    /**
     * Scope: Lấy câu hỏi đã trả lời
     */
    public function scopeAnswered($query)
    {
        return $query->where('is_answered', 1);
    }

    /**
     * Scope: Lấy câu hỏi của user hiện tại
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Lấy câu hỏi theo danh mục
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
