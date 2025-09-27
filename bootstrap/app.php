<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        // Đồng bộ trạng thái đơn hàng từ GHN mỗi 5 phút
        $schedule->command('ghn:sync-order-status --all')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->onOneServer()
            ->appendOutputTo(storage_path('logs/schedule-ghn-sync.log'));
    })
    ->withMiddleware(function (Middleware $middleware): void {
        // Đăng ký AdminMiddleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'check.cart' => \App\Http\Middleware\CheckCart::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Trả về thông báo tiếng Việt khi chưa đăng nhập cho AJAX/JSON
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson() || $request->ajax() || $request->is('api/*')) {
                return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
            }
            return redirect()->guest(route('login'))->with('error', 'Bạn chưa đăng nhập');
        });
    })->create();