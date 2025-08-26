<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author',
        'is_featured',
        'is_published',
        'views'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'views' => 'integer'
    ];

    // Tự động tạo slug từ title
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
        
        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // Scope để lấy tin đã xuất bản
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope để lấy tin nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope để lấy tin theo danh mục
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Tăng lượt xem
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Lấy URL đầy đủ của hình ảnh
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://via.placeholder.com/400x250/cccccc/666666?text=Không+có+ảnh';
    }

    // Lấy ngày tháng định dạng
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
