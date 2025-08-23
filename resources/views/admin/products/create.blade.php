@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="content-title">Thêm Sản Phẩm Mới</h1>
    <p class="content-subtitle">Tạo sản phẩm mới cho cửa hàng</p>
</div>

<div class="admin-form">
    @if(session('success'))
        <div class="admin-alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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
                        Hình Ảnh Sản Phẩm
                    </label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    <div class="form-text">Chấp nhận: JPEG, PNG, JPG, GIF. Tối đa: 2MB</div>
                    @error('image')
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
@endsection
