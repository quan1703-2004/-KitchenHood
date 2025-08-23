@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="content-title">Chỉnh Sửa Danh Mục</h1>
    <p class="content-subtitle">Cập nhật thông tin danh mục "{{ $category->name }}"</p>
</div>

<div class="admin-form">
    @if(session('success'))
        <div class="admin-alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="form-label">
                Tên Danh Mục <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $category->name) }}" 
                   placeholder="Nhập tên danh mục"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                        <span class="fw-bold">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">
                            <i class="fas fa-calendar-check me-1"></i><strong>Cập nhật cuối:</strong>
                        </small>
                        <span class="fw-bold">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.categories.index') }}" 
               class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Cập Nhật Danh Mục
            </button>
        </div>
    </form>
</div>
@endsection
