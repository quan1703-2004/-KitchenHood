@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="content-title">Chỉnh Sửa Sản Phẩm</h1>
    <p class="content-subtitle">Cập nhật thông tin sản phẩm "{{ $product->name }}"</p>
</div>

<div class="admin-form">
    @if(session('success'))
        <div class="admin-alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                           value="{{ old('name', $product->name) }}" 
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
                              required>{{ old('description', $product->description) }}</textarea>
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
                    
                    @if($product->image)
                        <div class="mb-3 text-center">
                            <img src="{{ $product->image_url }}" 
                                 alt="Hình ảnh hiện tại" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; border-radius: 12px;">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-image me-1"></i>Hình ảnh hiện tại
                            </small>
                        </div>
                    @endif
                    
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    <div class="form-text">Chấp nhận: JPEG, PNG, JPG, GIF. Tối đa: 2MB. Để trống nếu không muốn thay đổi.</div>
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
                           value="{{ old('quantity', $product->quantity) }}" 
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
                               value="{{ old('price', $product->price) }}" 
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
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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

        <div class="mb-4">
            <label class="form-label">
                Thông Tin Bổ Sung
            </label>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">
                            <i class="fas fa-calendar-plus me-1"></i><strong>Ngày tạo:</strong>
                        </small>
                        <span class="fw-bold">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">
                            <i class="fas fa-calendar-check me-1"></i><strong>Cập nhật cuối:</strong>
                        </small>
                        <span class="fw-bold">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
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
                <i class="fas fa-save me-2"></i>Cập Nhật Sản Phẩm
            </button>
        </div>
    </form>
</div>
@endsection
