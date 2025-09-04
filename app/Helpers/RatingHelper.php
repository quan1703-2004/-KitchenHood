<?php

namespace App\Helpers;

class RatingHelper
{
    /**
     * Hiển thị rating stars dựa trên rating trung bình
     */
    public static function displayStars($averageRating, $showHalfStar = true)
    {
        $html = '';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $averageRating) {
                // Star đầy đủ
                $html .= '<i class="fas fa-star text-warning"></i>';
            } elseif ($showHalfStar && $i - $averageRating < 1 && $i - $averageRating > 0) {
                // Star một nửa
                $html .= '<i class="fas fa-star-half-alt text-warning"></i>';
            } else {
                // Star rỗng
                $html .= '<i class="far fa-star text-muted"></i>';
            }
        }
        
        return $html;
    }

    /**
     * Hiển thị rating stars cho một review cụ thể
     */
    public static function displayReviewStars($rating)
    {
        $html = '';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $html .= '<i class="far fa-star text-muted"></i>';
            }
        }
        
        return $html;
    }

    /**
     * Hiển thị rating với text
     */
    public static function displayRatingText($averageRating, $reviewsCount = 0)
    {
        if ($reviewsCount > 0) {
            return number_format($averageRating, 1) . '/5 (' . $reviewsCount . ' đánh giá)';
        } else {
            return 'Chưa có đánh giá';
        }
    }

    /**
     * Hiển thị progress bar cho từng mức rating
     */
    public static function displayRatingProgress($ratingCounts, $totalReviews)
    {
        $html = '';
        
        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingCounts[$i] ?? 0;
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            
            $html .= '<div class="col-12">';
            $html .= '<div class="d-flex align-items-center">';
            $html .= '<small class="text-muted me-2" style="width: 30px;">' . $i . '★</small>';
            $html .= '<div class="progress flex-grow-1 me-2" style="height: 8px;">';
            $html .= '<div class="progress-bar bg-warning" style="width: ' . $percentage . '%"></div>';
            $html .= '</div>';
            $html .= '<small class="text-muted" style="width: 40px;">' . $count . '</small>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
        return $html;
    }
}
