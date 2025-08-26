<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsData = [
            [
                'title' => 'Xu Hướng Máy Hút Mùi 2025',
                'slug' => 'xu-huong-may-hut-mui-2025',
                'excerpt' => 'Khám phá những xu hướng mới nhất trong thiết kế và công nghệ máy hút mùi cho căn bếp hiện đại năm 2025.',
                'content' => '<h2>Xu Hướng Thiết Kế 2025</h2>
                <p>Năm 2025 mang đến những xu hướng thiết kế máy hút mùi hoàn toàn mới, tập trung vào tính thẩm mỹ và hiệu quả sử dụng.</p>
                
                <h3>1. Thiết Kế Tối Giản</h3>
                <p>Xu hướng thiết kế tối giản tiếp tục thống trị thị trường với những đường nét sạch sẽ, màu sắc trung tính và kiểu dáng hiện đại.</p>
                
                <h3>2. Công Nghệ Thông Minh</h3>
                <p>Các dòng máy hút mùi mới được tích hợp công nghệ IoT, cho phép điều khiển từ xa qua smartphone và tự động điều chỉnh tốc độ hút.</p>
                
                <h3>3. Tiết Kiệm Năng Lượng</h3>
                <p>Với công nghệ inverter tiên tiến, máy hút mùi 2025 tiết kiệm điện năng lên đến 40% so với các dòng cũ.</p>
                
                <h3>4. Vật Liệu Cao Cấp</h3>
                <p>Sử dụng thép không gỉ 304, kính cường lực và các vật liệu chống bám dính giúp dễ dàng vệ sinh và bảo trì.</p>',
                'image' => null,
                'category' => 'xu-hướng',
                'author' => 'Admin',
                'is_featured' => true,
                'is_published' => true,
                'views' => 156
            ],
            [
                'title' => 'Cách Bảo Trì Máy Hút Mùi',
                'slug' => 'cach-bao-tri-may-hut-mui',
                'excerpt' => 'Hướng dẫn chi tiết cách vệ sinh và bảo trì máy hút mùi để đảm bảo hiệu suất tối ưu và tuổi thọ lâu dài.',
                'content' => '<h2>Hướng Dẫn Bảo Trì Máy Hút Mùi</h2>
                <p>Việc bảo trì định kỳ máy hút mùi không chỉ giúp tăng tuổi thọ sản phẩm mà còn đảm bảo hiệu suất hoạt động tối ưu.</p>
                
                <h3>1. Vệ Sinh Bộ Lọc</h3>
                <p><strong>Tần suất:</strong> Mỗi tháng 1 lần</p>
                <ul>
                    <li>Tháo bộ lọc khỏi máy</li>
                    <li>Ngâm trong nước ấm với xà phòng</li>
                    <li>Chải nhẹ bằng bàn chải mềm</li>
                    <li>Rửa sạch và để khô hoàn toàn</li>
                </ul>
                
                <h3>2. Vệ Sinh Thân Máy</h3>
                <p><strong>Tần suất:</strong> Mỗi tuần 1 lần</p>
                <ul>
                    <li>Dùng khăn ẩm lau bề mặt ngoài</li>
                    <li>Tránh sử dụng hóa chất mạnh</li>
                    <li>Lau khô bằng khăn mềm</li>
                </ul>
                
                <h3>3. Kiểm Tra Định Kỳ</h3>
                <p><strong>Tần suất:</strong> Mỗi 6 tháng</p>
                <ul>
                    <li>Kiểm tra dây điện và ổ cắm</li>
                    <li>Làm sạch quạt gió</li>
                    <li>Kiểm tra độ rung và tiếng ồn</li>
                </ul>',
                'image' => null,
                'category' => 'hướng-dẫn',
                'author' => 'Admin',
                'is_featured' => true,
                'is_published' => true,
                'views' => 89
            ],
            [
                'title' => 'Khuyến Mãi Tết Nguyên Đán',
                'slug' => 'khuyen-mai-tet-nguyen-dan',
                'excerpt' => 'Chương trình khuyến mãi đặc biệt nhân dịp Tết Nguyên Đán với nhiều ưu đãi hấp dẫn cho khách hàng.',
                'content' => '<h2>Chương Trình Khuyến Mãi Tết 2025</h2>
                <p>Nhân dịp Tết Nguyên Đán, KitchenHood Pro mang đến chương trình khuyến mãi đặc biệt với nhiều ưu đãi hấp dẫn.</p>
                
                <h3>🎉 Ưu Đãi Đặc Biệt</h3>
                <ul>
                    <li><strong>Giảm giá 30%</strong> cho tất cả sản phẩm máy hút mùi</li>
                    <li><strong>Miễn phí vận chuyển</strong> toàn quốc</li>
                    <li><strong>Tặng kèm bộ lọc</strong> trị giá 500.000 VNĐ</li>
                    <li><strong>Bảo hành mở rộng</strong> lên 7 năm</li>
                </ul>
                
                <h3>📅 Thời Gian Áp Dụng</h3>
                <p><strong>Từ ngày:</strong> 15/01/2025<br>
                <strong>Đến ngày:</strong> 15/02/2025</p>
                
                <h3>🎁 Quà Tặng Đặc Biệt</h3>
                <p>Khách hàng mua từ 2 sản phẩm trở lên sẽ được tặng thêm:</p>
                <ul>
                    <li>Bộ dụng cụ vệ sinh chuyên dụng</li>
                    <li>Gói bảo trì miễn phí 1 năm</li>
                    <li>Hướng dẫn sử dụng chi tiết</li>
                </ul>
                
                <h3>📞 Liên Hệ Ngay</h3>
                <p>Để được tư vấn và đặt hàng, vui lòng liên hệ:</p>
                <ul>
                    <li><strong>Hotline:</strong> 1900 1234</li>
                    <li><strong>Email:</strong> sales@kitchenhoodpro.com</li>
                    <li><strong>Website:</strong> www.kitchenhoodpro.com</li>
                </ul>',
                'image' => null,
                'category' => 'khuyến-mãi',
                'author' => 'Admin',
                'is_featured' => true,
                'is_published' => true,
                'views' => 234
            ],
            [
                'title' => 'Công Nghệ Lọc Không Khí Mới',
                'slug' => 'cong-nghe-loc-khong-khi-moi',
                'excerpt' => 'Khám phá công nghệ lọc không khí tiên tiến mới nhất được tích hợp trong các dòng máy hút mùi cao cấp hiện nay.',
                'content' => '<h2>Công Nghệ Lọc Không Khí Tiên Tiến</h2>
                <p>Công nghệ lọc không khí trong máy hút mùi đã có những bước tiến vượt bậc, mang lại hiệu quả lọc sạch tối ưu.</p>
                
                <h3>1. Bộ Lọc HEPA</h3>
                <p>Bộ lọc HEPA (High Efficiency Particulate Air) có khả năng lọc 99.97% các hạt bụi có kích thước từ 0.3 micron trở lên.</p>
                
                <h3>2. Công Nghệ Ion Âm</h3>
                <p>Ion âm giúp trung hòa các chất độc hại trong không khí, tạo ra môi trường trong lành và an toàn cho sức khỏe.</p>
                
                <h3>3. Bộ Lọc Than Hoạt Tính</h3>
                <p>Than hoạt tính có khả năng hấp thụ mùi hôi và các chất hữu cơ bay hơi (VOC) hiệu quả.</p>
                
                <h3>4. Công Nghệ UV-C</h3>
                <p>Tia UV-C có khả năng tiêu diệt vi khuẩn, virus và nấm mốc, đảm bảo không khí sạch khuẩn.</p>
                
                <h3>5. Bộ Lọc Nano Silver</h3>
                <p>Nano Silver có tính kháng khuẩn tự nhiên, giúp ngăn chặn sự phát triển của vi khuẩn trên bề mặt lọc.</p>',
                'image' => null,
                'category' => 'công-nghệ',
                'author' => 'Admin',
                'is_featured' => false,
                'is_published' => true,
                'views' => 67
            ],
            [
                'title' => 'Thiết Kế Nhà Bếp Hiện Đại',
                'slug' => 'thiet-ke-nha-bep-hien-dai',
                'excerpt' => 'Những xu hướng thiết kế nhà bếp hiện đại kết hợp với máy hút mùi để tạo nên không gian bếp hoàn hảo và tiện nghi.',
                'content' => '<h2>Xu Hướng Thiết Kế Nhà Bếp 2025</h2>
                <p>Thiết kế nhà bếp hiện đại không chỉ đẹp mắt mà còn phải thực dụng và tiện nghi cho cuộc sống hàng ngày.</p>
                
                <h3>1. Phong Cách Tối Giản</h3>
                <p>Thiết kế tối giản với đường nét sạch sẽ, màu sắc trung tính và không gian mở tạo cảm giác thoải mái.</p>
                
                <h3>2. Tích Hợp Công Nghệ Thông Minh</h3>
                <p>Máy hút mùi thông minh được tích hợp vào thiết kế tổng thể, có thể điều khiển qua app hoặc giọng nói.</p>
                
                <h3>3. Vật Liệu Cao Cấp</h3>
                <p>Sử dụng đá granite, thép không gỉ và gỗ tự nhiên tạo nên vẻ sang trọng và bền bỉ.</p>
                
                <h3>4. Ánh Sáng Tự Nhiên</h3>
                <p>Thiết kế cửa sổ lớn và ánh sáng LED giúp không gian bếp sáng sủa và tiết kiệm năng lượng.</p>
                
                <h3>5. Khu Vực Lưu Trữ Thông Minh</h3>
                <p>Hệ thống tủ kéo hiện đại với ngăn kéo sâu và kệ xoay giúp tối ưu không gian lưu trữ.</p>',
                'image' => null,
                'category' => 'thiết-kế',
                'author' => 'Admin',
                'is_featured' => false,
                'is_published' => true,
                'views' => 45
            ],
            [
                'title' => 'Máy Hút Mùi Tiết Kiệm Điện',
                'slug' => 'may-hut-mui-tiet-kiem-dien',
                'excerpt' => 'Cách chọn và sử dụng máy hút mùi để tiết kiệm điện năng hiệu quả mà vẫn đảm bảo hiệu suất hoạt động tối ưu.',
                'content' => '<h2>Tiết Kiệm Điện Với Máy Hút Mùi</h2>
                <p>Việc sử dụng máy hút mùi hiệu quả không chỉ giúp tiết kiệm điện mà còn bảo vệ môi trường.</p>
                
                <h3>1. Chọn Công Suất Phù Hợp</h3>
                <p>Không phải công suất cao luôn tốt. Chọn công suất phù hợp với kích thước bếp để tiết kiệm điện.</p>
                
                <h3>2. Sử Dụng Công Nghệ Inverter</h3>
                <p>Máy hút mùi với công nghệ Inverter tiết kiệm điện lên đến 40% so với máy thông thường.</p>
                
                <h3>3. Điều Chỉnh Tốc Độ Hợp Lý</h3>
                <p>Chỉ sử dụng tốc độ cao khi cần thiết, thường xuyên sử dụng tốc độ thấp và trung bình.</p>
                
                <h3>4. Vệ Sinh Định Kỳ</h3>
                <p>Bộ lọc bẩn làm tăng tiêu thụ điện. Vệ sinh định kỳ giúp máy hoạt động hiệu quả hơn.</p>
                
                <h3>5. Tắt Máy Khi Không Sử Dụng</h3>
                <p>Luôn tắt máy hút mùi khi không nấu ăn để tiết kiệm điện năng.</p>
                
                <h3>6. Sử Dụng Đèn LED</h3>
                <p>Chọn máy hút mùi có đèn LED thay vì đèn halogen để tiết kiệm điện.</p>',
                'image' => null,
                'category' => 'tiết-kiệm',
                'author' => 'Admin',
                'is_featured' => false,
                'is_published' => true,
                'views' => 78
            ]
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }
    }
}
