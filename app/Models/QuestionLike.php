<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionLike extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
    ];

    /**
     * Relationship với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
