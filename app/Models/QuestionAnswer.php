<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionAnswer extends Model
{
    use HasFactory;

    // Chỉ định tên bảng chính xác
    protected $table = 'questions_answers';

    protected $fillable = [
        'user_id',
        'admin_id', 
        'content',
        'is_question',
        'parent_id'
    ];

    /**
     * Relationship với User - người hỏi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với User - admin trả lời
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Relationship với QuestionAnswer - câu hỏi gốc
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(QuestionAnswer::class, 'parent_id');
    }

    /**
     * Relationship với QuestionAnswer - các câu trả lời
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'parent_id')->where('is_question', 0);
    }

    /**
     * Scope để lấy chỉ câu hỏi
     */
    public function scopeQuestions($query)
    {
        return $query->where('is_question', 1);
    }

    /**
     * Scope để lấy chỉ câu trả lời
     */
    public function scopeAnswers($query)
    {
        return $query->where('is_question', 0);
    }

    /**
     * Scope để lấy câu hỏi chưa có trả lời
     */
    public function scopeUnanswered($query)
    {
        return $query->questions()->whereDoesntHave('answers');
    }

    /**
     * Scope để lấy câu hỏi đã có trả lời
     */
    public function scopeAnswered($query)
    {
        return $query->questions()->whereHas('answers');
    }

    /**
     * Kiểm tra xem câu hỏi đã có trả lời chưa
     */
    public function isAnswered(): bool
    {
        return $this->answers()->exists();
    }

    /**
     * Lấy câu trả lời đầu tiên
     */
    public function getFirstAnswer()
    {
        return $this->answers()->first();
    }

    /**
     * Format ngày tạo
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
