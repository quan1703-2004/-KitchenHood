@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi Tiết Tồn Kho - {{ $product->name }}</h1>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay Lại
        </a>
    </div>

    <div class="row">
        <!-- Thông tin sản phẩm -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông Tin Sản Phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px;">
                        @else
                            <img src="https://via.placeholder.com/200x200/cccccc/666666?text=Không+có+ảnh" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded">
                        @endif
                    </div>

                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ $product->description }}</p>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Danh mục:</strong><br>
                            <span class="badge bg-info">{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-6">
                            <strong>Giá:</strong><br>
                            <span class="text-primary fw-bold">{{ number_format($product->price) }} VNĐ</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Tồn kho:</strong><br>
                            <span class="h4 {{ $product->quantity <= 0 ? 'text-danger' : ($product->quantity <= 10 ? 'text-warning' : 'text-success') }}">
                                {{ $product->quantity }}
                            </span>
                        </div>
                        <div class="col-6">
                            <strong>Trạng thái:</strong><br>
                            @if($product->quantity <= 0)
                                <span class="badge bg-danger">Hết hàng</span>
                            @elseif($product->quantity <= 10)
                                <span class="badge bg-warning">Sắp hết hàng</span>
                            @else
                                <span class="badge bg-success">Còn hàng</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <strong>Ngày tạo:</strong><br>
                            <small class="text-muted">{{ $product->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="col-6">
                            <strong>Cập nhật:</strong><br>
                            <small class="text-muted">{{ $product->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form nhập hàng -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nhập Hàng</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.inventory.add-stock', $product) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Số lượng nhập <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" 
                                           name="quantity" 
                                           min="1" 
                                           value="{{ old('quantity') }}" 
                                           required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="3" 
                                              placeholder="Ghi chú về lô hàng nhập...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Nhập Hàng
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Làm Mới
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lịch sử giao dịch -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch Sử Giao Dịch Gần Đây</h6>
                </div>
                <div class="card-body">
                    @if($product->inventoryTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Loại</th>
                                        <th>Số lượng</th>
                                        <th>Tồn kho trước</th>
                                        <th>Tồn kho sau</th>
                                        <th>Người thực hiện</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->inventoryTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($transaction->type === 'in')
                                                <span class="badge bg-success">Nhập hàng</span>
                                            @else
                                                <span class="badge bg-danger">Xuất hàng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $transaction->quantity }}</strong>
                                        </td>
                                        <td>{{ $transaction->quantity_before }}</td>
                                        <td>{{ $transaction->quantity_after }}</td>
                                        <td>{{ $transaction->user_name }}</td>
                                        <td>
                                            @if($transaction->notes)
                                                <small class="text-muted">{{ Str::limit($transaction->notes, 50) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">Chưa có giao dịch nào cho sản phẩm này.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Validate form nhập hàng
    $('#quantity').on('input', function() {
        const value = parseInt($(this).val());
        if (value <= 0) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Số lượng phải lớn hơn 0');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
@endpush
