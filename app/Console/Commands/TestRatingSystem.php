<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class TestRatingSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test rating system functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Rating System...');
        
        $product = Product::with('reviews')->first();
        
        if (!$product) {
            $this->error('Không có sản phẩm nào');
            return;
        }
        
        $this->info('Product: ' . $product->name);
        $this->info('Average Rating: ' . $product->average_rating);
        $this->info('Reviews Count: ' . $product->reviews_count);
        $this->info('Has Reviews: ' . ($product->has_reviews ? 'Yes' : 'No'));
        
        $this->info('Rating Counts:');
        $ratingCounts = $product->rating_count;
        foreach ($ratingCounts as $rating => $count) {
            $this->line("  {$rating} stars: {$count}");
        }
        
        $this->info('Latest Review:');
        $latestReview = $product->latest_review;
        if ($latestReview) {
            $this->line("  Rating: {$latestReview->rating}/5");
            $this->line("  User: {$latestReview->user->name}");
            $this->line("  Comment: " . substr($latestReview->comment, 0, 50) . "...");
        }
        
        $this->info('Rating system is working correctly!');
    }
}
