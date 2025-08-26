@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit me-2"></i>Chỉnh Sửa Tin Tức
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Tiêu đề -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $news->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tóm tắt -->
                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Tóm tắt <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" 
                                              name="excerpt" 
                                              rows="3" 
                                              required>{{ old('excerpt', $news->excerpt) }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nội dung -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" 
                                              name="content" 
                                              rows="15" 
                                              required>{{ old('content', $news->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Hình ảnh hiện tại -->
                                @if($news->image)
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh hiện tại</label>
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $news->image) }}" 
                                             alt="{{ $news->title }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                </div>
                                @endif

                                <!-- Hình ảnh mới -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Hình ảnh mới</label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                                </div>

                                <!-- Danh mục -->
                                <div class="mb-3">
                                    <label for="category" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            id="category" 
                                            name="category" 
                                            required>
                                        <option value="">Chọn danh mục</option>
                                        <option value="xu-hướng" {{ old('category', $news->category) == 'xu-hướng' ? 'selected' : '' }}>Xu hướng</option>
                                        <option value="hướng-dẫn" {{ old('category', $news->category) == 'hướng-dẫn' ? 'selected' : '' }}>Hướng dẫn</option>
                                        <option value="khuyến-mãi" {{ old('category', $news->category) == 'khuyến-mãi' ? 'selected' : '' }}>Khuyến mãi</option>
                                        <option value="công-nghệ" {{ old('category', $news->category) == 'công-nghệ' ? 'selected' : '' }}>Công nghệ</option>
                                        <option value="thiết-kế" {{ old('category', $news->category) == 'thiết-kế' ? 'selected' : '' }}>Thiết kế</option>
                                        <option value="tiết-kiệm" {{ old('category', $news->category) == 'tiết-kiệm' ? 'selected' : '' }}>Tiết kiệm</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tác giả -->
                                <div class="mb-3">
                                    <label for="author" class="form-label">Tác giả <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('author') is-invalid @enderror" 
                                           id="author" 
                                           name="author" 
                                           value="{{ old('author', $news->author) }}" 
                                           required>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Thống kê -->
                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Thống kê</h6>
                                            <p class="card-text mb-1">
                                                <i class="fas fa-eye me-1"></i>Lượt xem: {{ $news->views }}
                                            </p>
                                            <p class="card-text mb-1">
                                                <i class="fas fa-calendar me-1"></i>Tạo: {{ $news->created_at->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="card-text mb-0">
                                                <i class="fas fa-edit me-1"></i>Sửa: {{ $news->updated_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng thái -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_featured" 
                                               name="is_featured" 
                                               value="1" 
                                               {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Tin nổi bật
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_published" 
                                               name="is_published" 
                                               value="1" 
                                               {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            Xuất bản
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập Nhật Tin Tức
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- TinyMCE Editor -->
<script src="https://cdn.tiny.cloud/1/wwmuhfsephb9a51wkxfwqe7szaqu500yv6xuhssh2171yf3u/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
    });
});
</script>
@endsection
