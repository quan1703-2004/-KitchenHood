<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy sản phẩm đầu tiên
        $product = Product::first();
        
        if (!$product) {
            $this->command->info('Không có sản phẩm nào để tạo đánh giá');
            return;
        }

        // Lấy users để tạo đánh giá
        $users = User::take(3)->get();
        
        if ($users->isEmpty()) {
            $this->command->info('Không có user nào để tạo đánh giá');
            return;
        }

        // Tạo các đánh giá mẫu
        $reviews = [
            [
                'user_id' => $users[0]->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Sản phẩm rất tốt, chất lượng cao! Máy hút mùi hoạt động hiệu quả, thiết kế đẹp và dễ sử dụng.'
            ],
            [
                'user_id' => $users->count() > 1 ? $users[1]->id : $users[0]->id,
                'product_id' => $product->id,
                'rating' => 4,
                'comment' => 'Sản phẩm tốt, giá cả hợp lý. Công suất hút mùi khá tốt, phù hợp với gia đình.'
            ],
            [
                'user_id' => $users->count() > 2 ? $users[2]->id : $users[0]->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Tuyệt vời! Đã sử dụng được 6 tháng, không có vấn đề gì. Âm thanh hoạt động êm ái.'
            ]
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        $this->command->info('Đã tạo ' . count($reviews) . ' đánh giá mẫu cho sản phẩm: ' . $product->name);
    }
}
