@props(['product'])

<div class="product-rating">
    @if($product->has_reviews)
        <!-- Rating tổng quan -->
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <x-rating-stars :rating="$product->average_rating" :showHalfStar="true" :size="'large'" />
                    <div class="ms-3">
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($product->average_rating, 1) }}/5</h4>
                        <small class="text-muted">{{ $product->reviews_count }} đánh giá</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-thumbs-up me-1"></i>
                        {{ number_format(($product->rating_count[5] + $product->rating_count[4]) / $product->reviews_count * 100, 0) }}% khuyến nghị
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Thống kê chi tiết rating -->
        <div class="bg-light rounded p-3 mb-3">
            <h6 class="fw-bold mb-3">Phân bố đánh giá</h6>
            <div class="row g-2">
                @for($i = 5; $i >= 1; $i--)
                    @php
                        $count = $product->rating_count[$i] ?? 0;
                        $percentage = $product->reviews_count > 0 ? ($count / $product->reviews_count) * 100 : 0;
                    @endphp
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center" style="width: 80px;">
                                <span class="fw-bold me-2">{{ $i }}</span>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <div class="progress flex-grow-1 mx-3" style="height: 12px;">
                                <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="text-end" style="width: 60px;">
                                <span class="fw-bold">{{ $count }}</span>
                                <small class="text-muted">({{ number_format($percentage, 0) }}%)</small>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    @else
        <div class="text-center py-4">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <x-rating-stars :rating="0" :showHalfStar="false" :size="'large'" />
            </div>
            <p class="text-muted mb-0">Chưa có đánh giá nào cho sản phẩm này</p>
            <small class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</small>
        </div>
    @endif
</div>
