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

    // quan hệ review sản phẩm
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Lấy rating trung bình của sản phẩm từ bảng reviews
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Lấy số lượng đánh giá của sản phẩm
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Lấy số lượng đánh giá theo từng mức sao
     */
    public function getRatingCountAttribute()
    {
        $ratings = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratings[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $ratings;
    }

    /**
     * Kiểm tra xem sản phẩm có đánh giá nào không
     */
    public function getHasReviewsAttribute()
    {
        return $this->reviews()->count() > 0;
    }

    /**
     * Lấy đánh giá mới nhất của sản phẩm
     */
    public function getLatestReviewAttribute()
    {
        return $this->reviews()->with('user')->latest()->first();
    }

    /**
     * Quan hệ với giao dịch tồn kho
     */
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Kiểm tra sản phẩm có còn hàng không
     */
    public function getIsInStockAttribute()
    {
        return $this->quantity > 0;
    }

    /**
     * Kiểm tra sản phẩm có sắp hết hàng không (dưới 10 sản phẩm)
     */
    public function getIsLowStockAttribute()
    {
        return $this->quantity > 0 && $this->quantity <= 10;
    }

    /**
     * Lấy trạng thái tồn kho dạng text
     */
    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return 'Hết hàng';
        } elseif ($this->quantity <= 10) {
            return 'Sắp hết hàng';
        } else {
            return 'Còn hàng';
        }
    }

    /**
     * Nhập hàng - tăng số lượng tồn kho
     */
    public function addStock($quantity, $notes = null, $userId = null)
    {
        $quantityBefore = $this->quantity;
        $this->quantity += $quantity;
        $this->save();

        // Ghi lại giao dịch nhập hàng
        InventoryTransaction::create([
            'product_id' => $this->id,
            'type' => 'in',
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $this->quantity,
            'notes' => $notes,
            'user_id' => $userId
        ]);

        return $this;
    }

    /**
     * Xuất hàng - giảm số lượng tồn kho
     */
    public function reduceStock($quantity, $notes = null, $orderId = null, $userId = null)
    {
        if ($this->quantity < $quantity) {
            throw new \Exception('Không đủ hàng trong kho');
        }

        $quantityBefore = $this->quantity;
        $this->quantity -= $quantity;
        $this->save();

        // Ghi lại giao dịch xuất hàng
        InventoryTransaction::create([
            'product_id' => $this->id,
            'type' => 'out',
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $this->quantity,
            'notes' => $notes,
            'order_id' => $orderId,
            'user_id' => $userId
        ]);

        return $this;
    }

    /**
     * Lấy lịch sử giao dịch tồn kho
     */
    public function getInventoryHistory($limit = 10)
    {
        return $this->inventoryTransactions()
            ->with(['user', 'order'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
