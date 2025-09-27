<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckTableStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:table-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check table structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔍 Checking table structures...");
        
        // Check orders table
        $this->line("📋 Orders table columns:");
        $ordersColumns = Schema::getColumnListing('orders');
        foreach ($ordersColumns as $column) {
            $this->line("   - {$column}");
        }
        
        $this->line("");
        
        // Check order_history table
        $this->line("📋 Order History table columns:");
        $historyColumns = Schema::getColumnListing('order_history');
        foreach ($historyColumns as $column) {
            $this->line("   - {$column}");
        }
        
        $this->line("");
        
        // Check if order_code exists
        if (in_array('order_code', $ordersColumns)) {
            $this->info("✅ order_code column exists in orders table");
        } else {
            $this->error("❌ order_code column NOT found in orders table");
        }
    }
}