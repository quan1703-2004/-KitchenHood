@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="users-header-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="users-title">
                <i class="fas fa-users me-3"></i>
                Quản lý Người dùng
            </h1>
            <p class="users-subtitle">Quản lý thông tin và quyền hạn của người dùng</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-create">
            <i class="fas fa-plus me-2"></i>Thêm người dùng
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Search and Filter Section -->
<div class="search-filter-section">
    <div class="search-card">
        <form method="GET" action="{{ route('admin.users.index') }}" class="search-form">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="search-group">
                        <label for="search" class="search-label">Tìm kiếm</label>
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   class="form-control search-input" 
                                   placeholder="Tìm theo tên hoặc email..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="search-group">
                        <label for="status" class="search-label">Trạng thái</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đã kích hoạt</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Chưa kích hoạt</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="search-group">
                        <label for="sort_by" class="search-label">Sắp xếp theo</label>
                        <select name="sort_by" id="sort_by" class="form-select">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="search-group">
                        <label class="search-label">&nbsp;</label>
                        <div class="search-buttons">
                            <button type="submit" class="btn btn-search">
                                <i class="fas fa-search me-1"></i>Tìm
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-reset">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table Section -->
<div class="users-table-section">
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-list me-2"></i>
                Danh sách người dùng ({{ $users->total() }} người dùng)
            </h3>
        </div>
        <div class="table-content">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Người dùng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Trạng thái</th>
                                <th>Quyền hạn</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="user-row">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="user-details">
                                            <h4 class="user-name">{{ $user->name }}</h4>
                                            <span class="user-id">ID: {{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="user-phone">Chưa có</span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Đã kích hoạt
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-clock me-1"></i>
                                            Chưa kích hoạt
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="role-badge role-admin">
                                            <i class="fas fa-crown me-1"></i>
                                            Admin
                                        </span>
                                    @else
                                        <span class="role-badge role-user">
                                            <i class="fas fa-user me-1"></i>
                                            Người dùng
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="created-date">{{ $user->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-action btn-view" 
                                           title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-action btn-edit" 
                                           title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái người dùng này?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-action {{ $user->email_verified_at ? 'btn-warning' : 'btn-success' }}" 
                                                    title="{{ $user->email_verified_at ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                                <i class="fas {{ $user->email_verified_at ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>
                                        @if($user->role !== 'admin')
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-action btn-delete" 
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-section">
                    {{ $users->links() }}
                </div>
            @else
                <div class="no-data">
                    <div class="no-data-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Không có người dùng nào</h3>
                    <p>Chưa có người dùng nào trong hệ thống.</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-create">
                        <i class="fas fa-plus me-2"></i>Thêm người dùng đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* ===== USER MANAGEMENT STYLES ===== */
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
.users-header-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.users-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.users-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.users-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

.btn-create {
    background: linear-gradient(135deg, var(--success-color) 0%, #34d399 100%);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-create:hover {
    background: linear-gradient(135deg, #059669 0%, var(--success-color) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
    text-decoration: none;
}

/* Search and Filter Section */
.search-filter-section {
    margin-bottom: 2rem;
}

.search-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.search-form .row {
    align-items: end;
}

.search-group {
    margin-bottom: 0;
}

.search-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.875rem;
}

.search-input-group {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    z-index: 2;
}

.search-input {
    padding-left: 2.5rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.form-select {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.search-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-search {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.btn-search:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-reset {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    background: var(--text-light);
    color: white;
    text-decoration: none;
}

/* Users Table Section */
.users-table-section {
    margin-bottom: 2rem;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.table-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.table-title i {
    color: var(--primary-color);
}

.table-content {
    padding: 0;
}

.users-table {
    width: 100%;
    margin: 0;
}

.users-table thead th {
    background: var(--bg-light);
    border: none;
    padding: 1.25rem 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--border-color);
}

.users-table tbody td {
    border: none;
    padding: 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--border-color);
}

.users-table tbody tr:hover {
    background: var(--bg-light);
}

.users-table tbody tr:last-child td {
    border-bottom: none;
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    color: var(--text-muted);
    font-size: 1.25rem;
}

.user-details {
    min-width: 0;
}

.user-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.user-id {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}

.user-email {
    font-size: 0.875rem;
    color: var(--text-dark);
    font-weight: 500;
}

.user-phone {
    font-size: 0.875rem;
    color: var(--text-light);
}

.created-date {
    font-size: 0.875rem;
    color: var(--text-light);
    font-weight: 500;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
}

.status-active {
    background: var(--success-color);
    color: white;
}

.status-inactive {
    background: var(--warning-color);
    color: white;
}

/* Role Badges */
.role-badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
}

.role-admin {
    background: var(--primary-color);
    color: white;
}

.role-user {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-view {
    background: var(--info-color);
    color: white;
}

.btn-view:hover {
    background: #0284c7;
    color: white;
    transform: translateY(-1px);
}

.btn-edit {
    background: var(--warning-color);
    color: white;
}

.btn-edit:hover {
    background: #d97706;
    color: white;
    transform: translateY(-1px);
}

.btn-delete {
    background: var(--danger-color);
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    color: white;
    transform: translateY(-1px);
}

.btn-success {
    background: var(--success-color);
    color: white;
}

.btn-success:hover {
    background: #059669;
    color: white;
    transform: translateY(-1px);
}

.btn-warning {
    background: var(--warning-color);
    color: white;
}

.btn-warning:hover {
    background: #d97706;
    color: white;
    transform: translateY(-1px);
}

/* Pagination */
.pagination-section {
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    background: var(--bg-light);
}

.pagination-section .pagination {
    margin: 0;
    justify-content: center;
}

.pagination-section .page-link {
    color: var(--primary-color);
    border-color: var(--border-color);
    border-radius: 8px;
    margin: 0 0.25rem;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination-section .page-link:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-1px);
}

.pagination-section .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
}

/* No Data */
.no-data {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.no-data-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.no-data h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.no-data p {
    font-size: 1rem;
    margin-bottom: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .users-header-section {
        padding: 1.5rem;
    }
    
    .users-title {
        font-size: 1.5rem;
    }
    
    .search-card {
        padding: 1.5rem;
    }
    
    .search-form .row {
        flex-direction: column;
    }
    
    .search-buttons {
        width: 100%;
        justify-content: center;
    }
    
    .users-table {
        font-size: 0.875rem;
    }
    
    .users-table thead th,
    .users-table tbody td {
        padding: 1rem 0.75rem;
    }
    
    .user-info {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .action-buttons {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .users-header-section {
        padding: 1rem;
    }
    
    .search-card {
        padding: 1rem;
    }
    
    .table-header {
        padding: 1rem;
    }
    
    .users-table thead th,
    .users-table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
}
</style>
@endsection
