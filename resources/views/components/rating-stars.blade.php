@props(['rating', 'showCount' => false, 'showHalfStar' => true, 'size' => 'normal'])

@php
    $sizeClass = match($size) {
        'small' => 'fa-sm',
        'large' => 'fa-lg',
        'xlarge' => 'fa-2x',
        default => ''
    };
@endphp

<div class="rating-stars d-inline-flex align-items-center">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            <i class="fas fa-star text-warning {{ $sizeClass }} me-1"></i>
        @elseif($showHalfStar && $i - $rating < 1 && $i - $rating > 0)
            <i class="fas fa-star-half-alt text-warning {{ $sizeClass }} me-1"></i>
        @else
            <i class="far fa-star text-muted {{ $sizeClass }} me-1"></i>
        @endif
    @endfor
    
    @if($showCount)
        <span class="text-muted ms-2">({{ number_format($rating, 1) }})</span>
    @endif
</div>
