@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2"><i class="fas fa-newspaper me-2 text-primary"></i>Quản Lý Tin Tức</h1>
                <p class="text-muted mb-0">Tạo, chỉnh sửa và quản lý bài viết</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-success btn-lg px-4">
                <i class="fas fa-plus me-2"></i>Thêm Tin Tức Mới
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card admin-table">
                <div class="card-body p-0">
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình Ảnh</th>
                                    <th>Tiêu Đề</th>
                                    <th>Danh Mục</th>
                                    <th>Tác Giả</th>
                                    <th>Trạng Thái</th>
                                    <th>Lượt Xem</th>
                                    <th>Ngày Tạo</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>
                                        @if($article->image)
                                            <img src="{{ asset('storage/' . $article->image) }}" 
                                                 alt="{{ $article->title }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($article->title, 50) }}</div>
                                        @if($article->is_featured)
                                            <span class="badge badge-success">Nổi bật</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($article->category) }}</span>
                                    </td>
                                    <td>{{ $article->author }}</td>
                                    <td>
                                        @if($article->is_published)
                                            <span class="badge badge-success">Đã xuất bản</span>
                                        @else
                                            <span class="badge badge-secondary">Bản nháp</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-eye me-1"></i>{{ $article->views }}
                                    </td>
                                    <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('news.show', $article->slug) }}" 
                                               class="btn btn-sm btn-view" 
                                               target="_blank"
                                               title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.news.edit', $article) }}" 
                                               class="btn btn-sm btn-edit"
                                               title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.news.destroy', $article) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-delete"
                                                        title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-newspaper fa-3x mb-3"></i>
                                            <h5>Chưa có tin tức nào</h5>
                                            <p>Hãy tạo tin tức đầu tiên của bạn!</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($news->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $news->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
