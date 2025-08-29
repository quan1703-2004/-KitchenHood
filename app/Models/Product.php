<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // Các trường có thể fill
    protected $fillable = [
        'name',
        'description', 
        'image',
        'image2',
        'image3',
        'quantity',
        'price',
        'features',
        'category_id',
        'is_active'
    ];
    
    // Cast các trường đặc biệt
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'quantity' => 'integer'
    ];
    
    // Quan hệ 1-1 với Category (1 product thuộc 1 category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Lấy đường dẫn hình ảnh đầy đủ
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Sử dụng storage link để truy cập ảnh
            return asset('storage/' . $this->image);
        }
        return 'https://via.placeholder.com/300x300?text=No+Image';
    }

    /**
     * Quan hệ chi tiết sản phẩm (1-1)
     */
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }
}
