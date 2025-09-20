@props(['name' => 'rating', 'value' => 0, 'size' => 'normal'])

@php
    $sizeClass = match($size) {
        'small' => 'fa-sm',
        'large' => 'fa-lg',
        'xlarge' => 'fa-2x',
        default => ''
    };
@endphp

<div class="rating-stars-interactive" data-name="{{ $name }}">
    @for($i = 1; $i <= 5; $i++)
        <i class="fas fa-star rating-star {{ $sizeClass }} me-1" 
           data-rating="{{ $i }}"
           style="cursor: pointer; color: {{ $i <= $value ? '#fbbf24' : '#d1d5db' }}; transition: color 0.2s ease;"></i>
    @endfor
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" id="{{ $name }}_input">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingContainer = document.querySelector('.rating-stars-interactive[data-name="{{ $name }}"]');
    if (!ratingContainer) return;
    
    const stars = ratingContainer.querySelectorAll('.rating-star');
    const hiddenInput = ratingContainer.querySelector('input[type="hidden"]');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            hiddenInput.value = rating;
            
            // Cập nhật màu sắc các sao
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#d1d5db';
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#f59e0b';
                } else {
                    s.style.color = '#d1d5db';
                }
            });
        });
    });
    
    ratingContainer.addEventListener('mouseleave', function() {
        const currentRating = parseInt(hiddenInput.value);
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.style.color = '#fbbf24';
            } else {
                s.style.color = '#d1d5db';
            }
        });
    });
});
</script>
