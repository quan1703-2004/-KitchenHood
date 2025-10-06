@extends('layouts.admin')

@section('content')
<style>
    .preview-map {
        height: 500px;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        margin-top: 1rem;
        position: relative;
    }
    
    .settings-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }
    
    .card-header-custom {
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .card-header-custom h5 {
        color: #1e293b;
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
    }
    
    .card-header-custom p {
        color: #64748b;
        margin: 0.5rem 0 0 0;
        font-size: 0.875rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }
    
    /* Autocomplete search box */
    .search-box-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .search-box {
        position: relative;
        z-index: 1000;
    }
    
    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 1001;
    }
    
    .autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 12px 12px;
        max-height: 300px;
        overflow-y: auto;
        display: none;
        z-index: 999;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .autocomplete-item:hover {
        background: #f8fafc;
        color: #3b82f6;
    }
    
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    
    .map-controls {
        margin-top: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    
    .map-controls small {
        color: #64748b;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .coordinate-display {
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-top: 0.5rem;
    }
    
    .coordinate-display strong {
        color: #1e293b;
    }
    
    .coordinate-display div {
        margin: 0.25rem 0;
    }
    
    .btn-outline-secondary {
        border: 2px solid #e2e8f0;
        color: #64748b;
        background: white;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }
    
    .leaflet-control-attribution {
        font-size: 10px;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1" style="color: #1e293b; font-weight: 700;">
                <i class="fas fa-cog me-2" style="color: #3b82f6;"></i>Cài đặt hệ thống
            </h3>
            <p class="text-muted mb-0">Quản lý thông tin liên hệ hiển thị trên trang khách hàng</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        
        <div class="row">
            <!-- Cột trái: Form nhập liệu -->
            <div class="col-lg-6">
                <!-- Thông tin liên hệ cơ bản -->
                <div class="settings-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-info-circle me-2"></i>Thông tin liên hệ</h5>
                        <p>Cập nhật thông tin liên hệ của doanh nghiệp</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-envelope me-1"></i>Email liên hệ *
                        </label>
                        <input 
                            type="email" 
                            name="contact_email" 
                            value="{{ old('contact_email', $settings->contact_email) }}" 
                            class="form-control @error('contact_email') is-invalid @enderror" 
                            placeholder="admin@example.com"
                            required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-phone me-1"></i>Số điện thoại
                        </label>
                        <input 
                            type="text" 
                            name="contact_phone" 
                            value="{{ old('contact_phone', $settings->contact_phone) }}" 
                            class="form-control @error('contact_phone') is-invalid @enderror"
                            placeholder="0987 654 321">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Địa chỉ
                        </label>
                        <input 
                            type="text" 
                            name="contact_address" 
                            id="contact_address"
                            value="{{ old('contact_address', $settings->contact_address) }}" 
                            class="form-control @error('contact_address') is-invalid @enderror"
                            placeholder="Xuân La - Tây Hồ - Hà Nội">
                        @error('contact_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Cài đặt bản đồ -->
                <div class="settings-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-map me-2"></i>Cài đặt bản đồ</h5>
                        <p>Tìm kiếm và chọn vị trí trên bản đồ</p>
                    </div>
                    
                    <!-- Tìm kiếm địa điểm -->
                    <div class="search-box-wrapper">
                        <label class="form-label">
                            <i class="fas fa-search me-1"></i>Tìm kiếm địa điểm
                        </label>
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input 
                                type="text" 
                                id="location-search" 
                                placeholder="Nhập tên địa điểm để tìm kiếm..."
                                autocomplete="off">
                            <div id="search-results" class="autocomplete-results"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-code me-1"></i>Mã nhúng bản đồ (iframe)
                        </label>
                        <textarea 
                            name="contact_map_embed" 
                            id="contact_map_embed"
                            rows="4" 
                            class="form-control @error('contact_map_embed') is-invalid @enderror" 
                            placeholder="<iframe src='...' width='100%' height='400'></iframe>">{{ old('contact_map_embed', $settings->contact_map_embed) }}</textarea>
                        @error('contact_map_embed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Tìm kiếm địa điểm phía trên hoặc click vào bản đồ để tự động tạo mã nhúng
                        </small>
                    </div>

                    <div class="map-controls">
                        <small><i class="fas fa-mouse-pointer me-1"></i>Vị trí đã chọn:</small>
                        <div class="coordinate-display" id="selectedCoordinates">
                            <div><strong>Địa điểm:</strong> <span id="selected-place">Chưa chọn</span></div>
                            <div><strong>Vĩ độ:</strong> <span id="selected-lat">-</span></div>
                            <div><strong>Kinh độ:</strong> <span id="selected-lng">-</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Bản đồ preview -->
            <div class="col-lg-6">
                <div class="settings-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-eye me-2"></i>Xem trước bản đồ</h5>
                        <p>Tìm kiếm hoặc click vào bản đồ để chọn vị trí</p>
                    </div>
                    
                    <div id="map" class="preview-map"></div>
                    
                    <div class="mt-3 d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetMap()">
                            <i class="fas fa-redo me-1"></i>Đặt lại vị trí mặc định
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="getCurrentLocation()">
                            <i class="fas fa-location-crosshairs me-1"></i>Vị trí hiện tại
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút lưu -->
        <div class="row">
            <div class="col-12">
                <div class="settings-card">
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save me-2"></i>Lưu cài đặt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // --- CẤU HÌNH ---
    const apiKey = 'eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjVkZjBjNjhjM2VmZTRhZjZhYWRkNjNhMjJjZmM0ZjhiIiwiaCI6Im11cm11cjY0In0=';
    
    // Tọa độ mặc định (Xuân La, Tây Hồ, Hà Nội)
    const defaultLat = 21.0685641;
    const defaultLng = 105.8172884;
    
    // Khởi tạo bản đồ
    const map = L.map('map').setView([defaultLat, defaultLng], 15);
    
    // Thêm tile layer từ OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Marker để đánh dấu vị trí
    let marker = L.marker([defaultLat, defaultLng], {
        draggable: true // Cho phép kéo marker
    }).addTo(map);
    
    // Biến lưu timeout cho debounce
    let debounceTimer;
    
    // Hàm tạo label địa chỉ từ kết quả tìm kiếm
    function createFormattedLabel(properties) {
        const parts = [
            properties.name,
            properties.locality,
            properties.county, 
            properties.region,
            properties.country
        ];
        const uniqueParts = [...new Set(parts)].filter(Boolean);
        return uniqueParts.join(', ');
    }
    
    // Hàm cập nhật thông tin vị trí
    function updateLocationInfo(lat, lng, placeName = '') {
        document.getElementById('selected-lat').textContent = lat.toFixed(6);
        document.getElementById('selected-lng').textContent = lng.toFixed(6);
        document.getElementById('selected-place').textContent = placeName || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
        
        // Tự động cập nhật địa chỉ vào input nếu có tên địa điểm
        if (placeName) {
            document.getElementById('contact_address').value = placeName;
        }
        
        // Tạo mã iframe Google Maps
        const iframe = `<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14892!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s" width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
        
        document.getElementById('contact_map_embed').value = iframe;
    }
    
    // Xử lý khi click vào bản đồ
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        marker.setLatLng([lat, lng]);
        updateLocationInfo(lat, lng);
        
        // Reverse geocoding để lấy tên địa điểm
        reverseGeocode(lat, lng);
    });
    
    // Xử lý khi kéo marker
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateLocationInfo(position.lat, position.lng);
        reverseGeocode(position.lat, position.lng);
    });
    
    // Hàm reverse geocoding (tìm tên địa điểm từ tọa độ)
    async function reverseGeocode(lat, lng) {
        try {
            const url = `https://api.openrouteservice.org/geocode/reverse?api_key=${apiKey}&point.lon=${lng}&point.lat=${lat}&size=1`;
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.features && data.features.length > 0) {
                const placeName = createFormattedLabel(data.features[0].properties);
                document.getElementById('selected-place').textContent = placeName;
                document.getElementById('contact_address').value = placeName;
            }
        } catch (error) {
            console.error('Lỗi reverse geocoding:', error);
        }
    }
    
    // Xử lý tìm kiếm địa điểm với autocomplete
    const searchInput = document.getElementById('location-search');
    const searchResults = document.getElementById('search-results');
    
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value;
        clearTimeout(debounceTimer);
        
        if (query.length < 3) {
            searchResults.innerHTML = '';
            searchResults.style.display = 'none';
            return;
        }
        
        debounceTimer = setTimeout(async () => {
            try {
                const url = `https://api.openrouteservice.org/geocode/autocomplete?api_key=${apiKey}&text=${query}&boundary.country=VNM&size=10`;
                const response = await fetch(url);
                const data = await response.json();
                
                searchResults.innerHTML = '';
                
                if (data.features && data.features.length > 0) {
                    searchResults.style.display = 'block';
                    
                    data.features.forEach(feature => {
                        const item = document.createElement('div');
                        item.className = 'autocomplete-item';
                        item.innerHTML = `<i class="fas fa-map-marker-alt me-2" style="color: #3b82f6;"></i>${createFormattedLabel(feature.properties)}`;
                        
                        item.onclick = () => {
                            const [lng, lat] = feature.geometry.coordinates;
                            const placeName = createFormattedLabel(feature.properties);
                            
                            // Di chuyển bản đồ và marker
                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);
                            
                            // Cập nhật thông tin
                            updateLocationInfo(lat, lng, placeName);
                            
                            // Đóng kết quả tìm kiếm
                            searchInput.value = placeName;
                            searchResults.innerHTML = '';
                            searchResults.style.display = 'none';
                        };
                        
                        searchResults.appendChild(item);
                    });
                } else {
                    searchResults.style.display = 'none';
                }
            } catch (error) {
                console.error('Lỗi tìm kiếm:', error);
                searchResults.innerHTML = '<div class="autocomplete-item text-danger"><i class="fas fa-exclamation-circle me-2"></i>Lỗi khi tìm kiếm</div>';
                searchResults.style.display = 'block';
            }
        }, 400);
    });
    
    // Đóng kết quả tìm kiếm khi click bên ngoài
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
    
    // Hàm reset bản đồ về vị trí mặc định
    function resetMap() {
        map.setView([defaultLat, defaultLng], 15);
        marker.setLatLng([defaultLat, defaultLng]);
        updateLocationInfo(defaultLat, defaultLng, 'Xuân La - Tây Hồ - Hà Nội');
        searchInput.value = '';
    }
    
    // Hàm lấy vị trí hiện tại
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateLocationInfo(lat, lng, 'Vị trí hiện tại của bạn');
                    reverseGeocode(lat, lng);
                },
                function(error) {
                    alert('Không thể lấy vị trí hiện tại: ' + error.message);
                }
            );
        } else {
            alert('Trình duyệt không hỗ trợ Geolocation');
        }
    }
    
    // Load vị trí từ iframe hiện có khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        const embedCode = document.getElementById('contact_map_embed').value;
        
        if (embedCode) {
            // Parse tọa độ từ iframe Google Maps
            const latMatch = embedCode.match(/!3d([0-9.-]+)/);
            const lngMatch = embedCode.match(/!2d([0-9.-]+)/);
            
            if (latMatch && lngMatch) {
                const lat = parseFloat(latMatch[1]);
                const lng = parseFloat(lngMatch[1]);
                
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
                updateLocationInfo(lat, lng);
                reverseGeocode(lat, lng);
            }
        }
    });
</script>
@endsection
