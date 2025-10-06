<h2>Thông tin liên hệ mới</h2>
<p><strong>Họ và tên:</strong> {{ $data['firstName'] ?? '' }}</p>
<p><strong>Email:</strong> {{ $data['email'] ?? '' }}</p>
<p><strong>Dịch vụ:</strong> {{ $data['service'] ?? '' }}</p>
<p><strong>Ngân sách:</strong> {{ $data['budget'] ?? 'Không cung cấp' }}</p>
<p><strong>Nội dung:</strong></p>
<pre style="white-space: pre-wrap; font-family: inherit;">{{ $data['message'] ?? '' }}</pre>
<hr>
<p>Được gửi từ trang Liên hệ.</p>


