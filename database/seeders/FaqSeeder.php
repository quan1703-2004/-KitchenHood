<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Seed the application's database with sample FAQs
     */
    public function run(): void
    {
        // Dữ liệu mẫu cho mục FAQ trên trang chủ
        $faqs = [
            [
                'question' => 'Chính sách vận chuyển như thế nào?',
                'answer' => '<p>Chúng tôi <strong>miễn phí vận chuyển toàn quốc</strong> cho đơn hàng từ 5.000.000 VNĐ. Thời gian giao hàng dự kiến từ 2-5 ngày làm việc tùy khu vực.</p>',
                'is_visible' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Sản phẩm được bảo hành bao lâu?',
                'answer' => '<p>Tất cả máy hút mùi đều được <strong>bảo hành 5 năm chính hãng</strong>. Vui lòng giữ hóa đơn/phiếu bảo hành để được hỗ trợ tốt nhất.</p>',
                'is_visible' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'Làm sao để vệ sinh máy hút mùi đúng cách?',
                'answer' => '<p>Vệ sinh lưới lọc 2 tuần/lần bằng nước ấm và xà phòng. Với máy dùng than hoạt tính, <strong>thay than lọc sau 6-12 tháng</strong> tùy mức sử dụng.</p>',
                'is_visible' => true,
                'sort_order' => 3,
            ],
            [
                'question' => 'Có hỗ trợ lắp đặt tại nhà không?',
                'answer' => '<p>Chúng tôi có <strong>dịch vụ lắp đặt tận nơi</strong> cho khách hàng tại các thành phố lớn. Phí lắp đặt được thông báo trước khi tiến hành.</p>',
                'is_visible' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $data) {
            // Tránh tạo trùng câu hỏi nếu đã seed trước đó
            Faq::firstOrCreate(
                [
                    'question' => $data['question'],
                ],
                $data
            );
        }
    }
}


