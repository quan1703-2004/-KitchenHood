<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_map_embed',
    ];

    public static function getSettings(): self
    {
        // Trả về bản ghi setting đầu tiên; nếu chưa có thì tạo mặc định từ ENV
        $settings = static::query()->first();
        if (!$settings) {
            $settings = static::query()->create([
                'contact_email' => env('MAIL_FROM_ADDRESS', 'admin@example.com'),
                'contact_phone' => '0987654321',
                'contact_address' => 'Xuân La - Tây Hồ - Hà Nội',
                'contact_map_embed' => '',
            ]);
        }
        return $settings;
    }
}


