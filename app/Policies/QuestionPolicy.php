<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    /**
     * Chỉ cho phép chủ sở hữu sửa câu hỏi khi chưa có trả lời từ admin.
     */
    public function update(User $user, Question $question): bool
    {
        if ($user->id !== $question->user_id) {
            return false;
        }

        // Nếu đã được đánh dấu đã trả lời thì chặn luôn
        if ($question->is_answered) {
            return false;
        }

        // Phòng trường hợp cờ is_answered chưa đồng bộ: kiểm tra có câu trả lời từ admin hay chưa
        return !$question->answers()
            ->whereHas('user', function ($q) {
                $q->where('role', 'admin');
            })
            ->exists();
    }
}


