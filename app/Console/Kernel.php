<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * Define the application's command schedule.
	 */
	protected function schedule(Schedule $schedule): void
	{
		// Đồng bộ trạng thái đơn hàng từ GHN mỗi 5 phút
		// - withoutOverlapping: tránh chạy trùng lặp nếu job trước chưa xong
		// - onOneServer: tránh chạy lặp trên multi-server (nếu có)
		$schedule->command('ghn:sync-order-status --all')
			->everyFiveMinutes()
			->withoutOverlapping()
			->onOneServer()
			->appendOutputTo(storage_path('logs/schedule-ghn-sync.log'));
	}

	/**
	 * Register the commands for the application.
	 */
	protected function commands(): void
	{
		$this->load(__DIR__.'/Commands');
	}
}