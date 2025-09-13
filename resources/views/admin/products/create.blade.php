@extends('layouts.admin')

@section('title', 'Thêm Sản Phẩm Mới - KitchenHood Pro')

@section('content')
<style>
/* ===== PRODUCT FORM STYLES ===== */
:root {
    --primary-color: #2563eb;
    --primary-light: #3b82f6;
    --primary-dark: #1d4ed8;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #0ea5e9;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --text-muted: #94a3b8;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* Header Section */
.product-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.product-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.product-title i {
    color: var(--success-color);
    font-size: 1.5rem;
}

.product-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

/* Form Section */
.product-form {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.form-text {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

/* Specs Section */
.specs-section {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
}

.spec-item {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.spec-item:hover {
    box-shadow: var(--shadow-sm);
}

/* Buttons */
.btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: var(--text-muted);
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    border: none;
}

.btn-danger {
    background: linear-gradient(135deg, var(--danger-color), #f87171);
    border: none;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    transform: translateY(-1px);
}

/* Alert */
.alert {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
}

/* Card */
.card {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
}

.card-body {
    padding: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .product-header, .product-form {
        padding: 1.5rem;
    }
    
    .product-title {
        font-size: 1.5rem;
    }
}
</style>

<!-- Header Section -->
<div class="product-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="product-title">
                <i class="fas fa-plus-circle me-3"></i>
                Thêm Sản Phẩm Mới
            </h1>
            <p class="product-subtitle">Tạo sản phẩm mới cho cửa hàng KitchenHood Pro</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay Lại
        </a>
    </div>
</div>

<!-- Form Section -->
<div class="product-form">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4">
                    <label for="name" class="form-label">
                        Tên Sản Phẩm <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Nhập tên sản phẩm"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">
                        Mô Tả <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5" 
                              placeholder="Nhập mô tả chi tiết sản phẩm"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-4">
                    <label for="image" class="form-label">
                        Hình Ảnh Chính <span class="text-danger">*</span>
                    </label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           required>
                    <div class="form-text">Chấp nhận: JPEG, PNG, JPG, GIF. Tối đa: 2MB</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image2" class="form-label">
                        Hình Ảnh Phụ 1
                    </label>
                    <input type="file" 
                           class="form-control @error('image2') is-invalid @enderror" 
                           id="image2" 
                           name="image2" 
                           accept="image/*">
                    <div class="form-text">Ảnh bổ sung cho sản phẩm</div>
                    @error('image2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image3" class="form-label">
                        Hình Ảnh Phụ 2
                    </label>
                    <input type="file" 
                           class="form-control @error('image3') is-invalid @enderror" 
                           id="image3" 
                           name="image3" 
                           accept="image/*">
                    <div class="form-text">Ảnh bổ sung cho sản phẩm</div>
                    @error('image3')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-4">
                    <label for="quantity" class="form-label">
                        Số Lượng <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" 
                           name="quantity" 
                           value="{{ old('quantity', 0) }}" 
                           min="0"
                           placeholder="0"
                           required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-4">
                    <label for="price" class="form-label">
                        Giá (VNĐ) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}" 
                               min="0" 
                               step="1000"
                               placeholder="0"
                               required>
                        <span class="input-group-text">VNĐ</span>
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-4">
                    <label for="category_id" class="form-label">
                        Danh Mục <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-list-ul me-2"></i>Chi Tiết Sản Phẩm
                    </label>
                    <div class="specs-section">
                        <div id="specs-container">
                            <div class="spec-item row mb-3">
                                <div class="col-md-5">
                                    <input type="text" 
                                           class="form-control spec-key" 
                                           placeholder="Tên thông số (VD: Công suất hút)"
                                           name="specs[0][key]">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" 
                                           class="form-control spec-value" 
                                           placeholder="Giá trị (VD: 600 m³/h)"
                                           name="specs[0][value]">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-spec">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-spec">
                            <i class="fas fa-plus me-1"></i>Thêm Thông Số
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.products.index') }}" 
               class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Lưu Sản Phẩm
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let specIndex = 1;
    
    // Thêm thông số mới
    document.getElementById('add-spec').addEventListener('click', function() {
        const container = document.getElementById('specs-container');
        const newSpec = document.createElement('div');
        newSpec.className = 'spec-item row mb-3';
        newSpec.innerHTML = `
            <div class="col-md-5">
                <input type="text" 
                       class="form-control spec-key" 
                       placeholder="Tên thông số (VD: Công suất hút)"
                       name="specs[${specIndex}][key]">
            </div>
            <div class="col-md-5">
                <input type="text" 
                       class="form-control spec-value" 
                       placeholder="Giá trị (VD: 600 m³/h)"
                       name="specs[${specIndex}][value]">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-spec">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newSpec);
        specIndex++;
    });
    
    // Xóa thông số
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-spec')) {
            e.target.closest('.spec-item').remove();
        }
    });
});
</script>
@endsection
