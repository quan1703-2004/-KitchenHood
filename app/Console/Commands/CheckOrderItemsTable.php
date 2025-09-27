<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckOrderItemsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:order-items-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check order_items table structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 Checking order_items table structure...");
        
        $columns = Schema::getColumnListing('order_items');
        
        $this->line("📋 Order Items table columns:");
        foreach ($columns as $column) {
            $this->line("   - {$column}");
        }
        
        $this->line("");
        
        // Kiểm tra các cột quan trọng
        $requiredColumns = ['id', 'order_id', 'product_id', 'quantity', 'price'];
        foreach ($requiredColumns as $col) {
            if (in_array($col, $columns)) {
                $this->info("✅ {$col} column exists");
            } else {
                $this->error("❌ {$col} column NOT found");
            }
        }
        
        // Kiểm tra product_name
        if (in_array('product_name', $columns)) {
            $this->info("✅ product_name column exists");
        } else {
            $this->warn("⚠️ product_name column NOT found - có thể cần thêm");
        }
    }
}