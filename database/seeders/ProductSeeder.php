<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo danh mục sản phẩm
        $categories = [
            'Máy hút mùi âm tủ',
            'Máy hút mùi kính cong',
            'Máy hút mùi đảo bếp',
            'Máy hút mùi ống khói',
            'Máy hút mùi mini',
            'Phụ kiện máy hút mùi'
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        // Lấy danh mục để sử dụng
        $amTuCategory = Category::where('name', 'Máy hút mùi âm tủ')->first();
        $kinhCongCategory = Category::where('name', 'Máy hút mùi kính cong')->first();
        $daoBepCategory = Category::where('name', 'Máy hút mùi đảo bếp')->first();
        $ongKhoiCategory = Category::where('name', 'Máy hút mùi ống khói')->first();
        $miniCategory = Category::where('name', 'Máy hút mùi mini')->first();
        $phuKienCategory = Category::where('name', 'Phụ kiện máy hút mùi')->first();

        // Sản phẩm máy hút mùi âm tủ
        $amTuProducts = [
            [
                'name' => 'Máy hút mùi âm tủ Bosch DWF97CR50',
                'description' => 'Máy hút mùi âm tủ cao cấp của Bosch với công suất 650m³/h, thiết kế hiện đại, tích hợp đèn LED, 3 tốc độ hút và bộ lọc than hoạt tính.',
                'quantity' => 15,
                'price' => 8500000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '650m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '3 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '65dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $amTuCategory->id
            ],
            [
                'name' => 'Máy hút mùi âm tủ Electrolux LFC97CR50',
                'description' => 'Máy hút mùi âm tủ Electrolux với thiết kế tối giản, công suất 600m³/h, bộ lọc 3 lớp hiệu quả, điều khiển cảm ứng và đèn LED chiếu sáng.',
                'quantity' => 12,
                'price' => 7200000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '600m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '3 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '62dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $amTuCategory->id
            ],
            [
                'name' => 'Máy hút mùi âm tủ Samsung NK36M5070DS',
                'description' => 'Máy hút mùi âm tủ Samsung với công nghệ Cyclone Force, công suất 550m³/h, bộ lọc thông minh và thiết kế phù hợp với mọi không gian bếp.',
                'quantity' => 18,
                'price' => 6800000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '550m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '3 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '64dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $amTuCategory->id
            ]
        ];

        // Sản phẩm máy hút mùi kính cong
        $kinhCongProducts = [
            [
                'name' => 'Máy hút mùi kính cong Bosch DWF97CR50',
                'description' => 'Máy hút mùi kính cong Bosch với thiết kế kính cong hiện đại, công suất 700m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.',
                'quantity' => 10,
                'price' => 9200000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '700m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '4 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '63dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $kinhCongCategory->id
            ],
            [
                'name' => 'Máy hút mùi kính cong Electrolux LFC97CR50',
                'description' => 'Máy hút mùi kính cong Electrolux với thiết kế kính cong 90 độ, công suất 650m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.',
                'quantity' => 14,
                'price' => 7800000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '650m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '4 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '61dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $kinhCongCategory->id
            ],
            [
                'name' => 'Máy hút mùi kính cong Samsung NK36M5070DS',
                'description' => 'Máy hút mùi kính cong Samsung với công nghệ Cyclone Force, công suất 600m³/h, bộ lọc thông minh và thiết kế kính cong hiện đại.',
                'quantity' => 16,
                'price' => 7500000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '600m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '3 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '62dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $kinhCongCategory->id
            ]
        ];

        // Sản phẩm máy hút mùi đảo bếp
        $daoBepProducts = [
            [
                'name' => 'Máy hút mùi đảo bếp Bosch DWF97CR50',
                'description' => 'Máy hút mùi đảo bếp Bosch với thiết kế đảo bếp hiện đại, công suất 800m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.',
                'quantity' => 8,
                'price' => 11500000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '800m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '4 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '65dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $daoBepCategory->id
            ],
            [
                'name' => 'Máy hút mùi đảo bếp Electrolux LFC97CR50',
                'description' => 'Máy hút mùi đảo bếp Electrolux với thiết kế đảo bếp sang trọng, công suất 750m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.',
                'quantity' => 12,
                'price' => 9800000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '750m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '4 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '63dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $daoBepCategory->id
            ],
            [
                'name' => 'Máy hút mùi đảo bếp Samsung NK36M5070DS',
                'description' => 'Máy hút mùi đảo bếp Samsung với công nghệ Cyclone Force, công suất 700m³/h, bộ lọc thông minh và thiết kế đảo bếp hiện đại.',
                'quantity' => 15,
                'price' => 9200000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '700m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '3 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '64dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $daoBepCategory->id
            ]
        ];

        // Sản phẩm máy hút mùi ống khói
        $ongKhoiProducts = [
            [
                'name' => 'Máy hút mùi ống khói Bosch DWF97CR50',
                'description' => 'Máy hút mùi ống khói Bosch với thiết kế ống khói hiện đại, công suất 900m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.',
                'quantity' => 6,
                'price' => 13500000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '900m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '5 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '67dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $ongKhoiCategory->id
            ],
            [
                'name' => 'Máy hút mùi ống khói Electrolux LFC97CR50',
                'description' => 'Máy hút mùi ống khói Electrolux với thiết kế ống khói sang trọng, công suất 850m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.',
                'quantity' => 8,
                'price' => 11800000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '850m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '5 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '65dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $ongKhoiCategory->id
            ],
            [
                'name' => 'Máy hút mùi ống khói Samsung NK36M5070DS',
                'description' => 'Máy hút mùi ống khói Samsung với công nghệ Cyclone Force, công suất 800m³/h, bộ lọc thông minh và thiết kế ống khói hiện đại.',
                'quantity' => 10,
                'price' => 11200000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '800m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '4 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '66dB'],
                    ['key' => 'Kích thước', 'value' => '900 x 500 x 500mm'],
                    ['key' => 'Bảo hành', 'value' => '2 năm']
                ],
                'category_id' => $ongKhoiCategory->id
            ]
        ];

        // Sản phẩm máy hút mùi mini
        $miniProducts = [
            [
                'name' => 'Máy hút mùi mini Bosch DWF97CR50',
                'description' => 'Máy hút mùi mini Bosch với thiết kế nhỏ gọn, công suất 300m³/h, bộ lọc than hoạt tính và điều khiển cơ đơn giản.',
                'quantity' => 25,
                'price' => 2800000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '300m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '2 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '58dB'],
                    ['key' => 'Kích thước', 'value' => '600 x 300 x 300mm'],
                    ['key' => 'Bảo hành', 'value' => '1 năm']
                ],
                'category_id' => $miniCategory->id
            ],
            [
                'name' => 'Máy hút mùi mini Electrolux LFC97CR50',
                'description' => 'Máy hút mùi mini Electrolux với thiết kế nhỏ gọn, công suất 280m³/h, bộ lọc 2 lớp và đèn LED chiếu sáng.',
                'quantity' => 30,
                'price' => 2500000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '280m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '2 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '56dB'],
                    ['key' => 'Kích thước', 'value' => '600 x 300 x 300mm'],
                    ['key' => 'Bảo hành', 'value' => '1 năm']
                ],
                'category_id' => $miniCategory->id
            ],
            [
                'name' => 'Máy hút mùi mini Samsung NK36M5070DS',
                'description' => 'Máy hút mùi mini Samsung với công nghệ Cyclone Force, công suất 320m³/h, bộ lọc thông minh và thiết kế nhỏ gọn.',
                'quantity' => 28,
                'price' => 3200000,
                'features' => [
                    ['key' => 'Công suất hút', 'value' => '320m³/h'],
                    ['key' => 'Số tốc độ', 'value' => '2 tốc độ'],
                    ['key' => 'Độ ồn', 'value' => '57dB'],
                    ['key' => 'Kích thước', 'value' => '600 x 300 x 300mm'],
                    ['key' => 'Bảo hành', 'value' => '1 năm']
                ],
                'category_id' => $miniCategory->id
            ]
        ];

        // Sản phẩm phụ kiện máy hút mùi
        $phuKienProducts = [
            [
                'name' => 'Bộ lọc than hoạt tính cho máy hút mùi',
                'description' => 'Bộ lọc than hoạt tính chất lượng cao, giúp loại bỏ mùi hôi và khói bếp hiệu quả. Phù hợp với hầu hết các loại máy hút mùi.',
                'quantity' => 100,
                'price' => 150000,
                'features' => [
                    ['key' => 'Chất liệu', 'value' => 'Than hoạt tính cao cấp'],
                    ['key' => 'Kích thước', 'value' => 'Phù hợp đa số máy hút mùi'],
                    ['key' => 'Tuổi thọ', 'value' => '6-12 tháng'],
                    ['key' => 'Hiệu quả', 'value' => 'Loại bỏ 99% mùi hôi'],
                    ['key' => 'Bảo hành', 'value' => '3 tháng']
                ],
                'category_id' => $phuKienCategory->id
            ],
            [
                'name' => 'Bộ lọc dầu mỡ cho máy hút mùi',
                'description' => 'Bộ lọc dầu mỡ chuyên dụng, giúp bảo vệ động cơ máy hút mùi khỏi dầu mỡ và bụi bẩn. Dễ dàng thay thế và vệ sinh.',
                'quantity' => 80,
                'price' => 120000,
                'features' => [
                    ['key' => 'Chất liệu', 'value' => 'Vải lọc chống dầu mỡ'],
                    ['key' => 'Kích thước', 'value' => 'Phù hợp đa số máy hút mùi'],
                    ['key' => 'Tuổi thọ', 'value' => '3-6 tháng'],
                    ['key' => 'Hiệu quả', 'value' => 'Lọc 95% dầu mỡ'],
                    ['key' => 'Bảo hành', 'value' => '3 tháng']
                ],
                'category_id' => $phuKienCategory->id
            ],
            [
                'name' => 'Ống thông gió mềm cho máy hút mùi',
                'description' => 'Ống thông gió mềm chất lượng cao, dễ dàng uốn cong và lắp đặt. Giúp thông gió hiệu quả cho máy hút mùi.',
                'quantity' => 60,
                'price' => 180000,
                'features' => [
                    ['key' => 'Chất liệu', 'value' => 'Nhôm mềm cao cấp'],
                    ['key' => 'Đường kính', 'value' => '150mm'],
                    ['key' => 'Chiều dài', 'value' => '2m'],
                    ['key' => 'Độ bền', 'value' => 'Chống ăn mòn'],
                    ['key' => 'Bảo hành', 'value' => '6 tháng']
                ],
                'category_id' => $phuKienCategory->id
            ],
            [
                'name' => 'Van một chiều cho máy hút mùi',
                'description' => 'Van một chiều chống ngược gió, giúp bảo vệ máy hút mùi khỏi gió ngược và côn trùng. Dễ dàng lắp đặt và bảo trì.',
                'quantity' => 45,
                'price' => 220000,
                'features' => [
                    ['key' => 'Chất liệu', 'value' => 'Nhựa ABS cao cấp'],
                    ['key' => 'Đường kính', 'value' => '150mm'],
                    ['key' => 'Chức năng', 'value' => 'Chống ngược gió'],
                    ['key' => 'Độ bền', 'value' => 'Chống ăn mòn'],
                    ['key' => 'Bảo hành', 'value' => '1 năm']
                ],
                'category_id' => $phuKienCategory->id
            ],
            [
                'name' => 'Bộ điều khiển cảm ứng cho máy hút mùi',
                'description' => 'Bộ điều khiển cảm ứng hiện đại, giúp điều khiển máy hút mùi một cách dễ dàng và chính xác. Tương thích với nhiều loại máy.',
                'quantity' => 35,
                'price' => 350000,
                'features' => [
                    ['key' => 'Chất liệu', 'value' => 'Kính cường lực'],
                    ['key' => 'Chức năng', 'value' => 'Điều khiển cảm ứng'],
                    ['key' => 'Tương thích', 'value' => 'Đa dạng máy hút mùi'],
                    ['key' => 'Độ bền', 'value' => 'Chống trầy xước'],
                    ['key' => 'Bảo hành', 'value' => '1 năm']
                ],
                'category_id' => $phuKienCategory->id
            ]
        ];

        // Gộp tất cả sản phẩm
        $allProducts = array_merge(
            $amTuProducts,
            $kinhCongProducts,
            $daoBepProducts,
            $ongKhoiProducts,
            $miniProducts,
            $phuKienProducts
        );

        // Tạo sản phẩm
        foreach ($allProducts as $productData) {
            Product::create($productData);
        }

        $this->command->info('Đã tạo thành công ' . count($allProducts) . ' sản phẩm máy hút mùi!');
    }
}
