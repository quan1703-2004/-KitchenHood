@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="content-title">Thêm Danh Mục Mới</h1>
    <p class="content-subtitle">Tạo danh mục sản phẩm mới cho hệ thống</p>
</div>

<div class="admin-form">
    @if(session('success'))
        <div class="admin-alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="form-label">
                Tên Danh Mục <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Nhập tên danh mục"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.categories.index') }}" 
               class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Lưu Danh Mục
            </button>
        </div>
    </form>
</div>
@endsection
