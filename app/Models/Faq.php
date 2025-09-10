<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    // Cho phép gán hàng loạt các trường sau
    protected $fillable = [
        'question',
        'answer',
        'is_visible',
        'sort_order',
    ];
}
