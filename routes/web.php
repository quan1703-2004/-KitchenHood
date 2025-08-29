<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Gửi link xác thực
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Link xác thực người dùng nhấp vào email
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    // Tìm user theo ID
    $user = \App\Models\User::find($id);
    
    if (!$user) {
        return redirect('/login')->with('error', 'User không tồn tại!');
    }
    
    // Kiểm tra hash email
    if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        return redirect('/login')->with('error', 'Link xác thực không hợp lệ!');
    }
    
    // Kiểm tra xem email đã được xác thực chưa
    if ($user->hasVerifiedEmail()) {
        return redirect('/login')->with('info', 'Email đã được xác thực rồi!');
    }
    
    // Xác thực email
    $user->email_verified_at = now();
    $user->save();
    
    return redirect('/login')->with('success', 'Email đã được xác thực thành công! Bây giờ bạn có thể đăng nhập.');
})->middleware(['signed'])->name('verification.verify');

// Resend link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link xác thực đã gửi lại!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Routes công khai - không cần đăng nhập
Route::get('/', function () {
    // Lấy sản phẩm mới nhất để hiển thị trên trang chủ
    $latestProducts = \App\Models\Product::with('category')->latest()->take(6)->get();
    $categories = \App\Models\Category::withCount('products')->take(4)->get();
    
    // Lấy tin tức nổi bật cho trang chủ
    $featuredNews = \App\Models\News::published()->featured()->take(3)->get();

    return view('customer.welcome', compact('latestProducts', 'categories', 'featuredNews'));
})->name('home');

// Routes cho tin tức
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Trang Liên hệ
Route::get('/contact', function () {
    return view('customer.contact');
})->name('contact');

// Routes đăng nhập/đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route tạm thời để kiểm tra user (sẽ xóa sau)
Route::get('/check-user/{email}', function($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if($user) {
        return response()->json([
            'found' => true,
            'name' => $user->name,
            'email_verified' => $user->email_verified_at ? true : false,
            'email_verified_at' => $user->email_verified_at,
            'role' => $user->role
        ]);
    }
    return response()->json(['found' => false]);
});

// Route tạm thời để gửi lại email xác thực (sẽ xóa sau)
Route::get('/resend-verification/{email}', function($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if($user) {
        if($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email đã được xác thực rồi!']);
        }
        
        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email xác thực đã được gửi lại!']);
    }
    return response()->json(['error' => 'User không tồn tại']);
});

// Route tạm thời để xác thực email thủ công (sẽ xóa sau)
Route::get('/manual-verify/{email}', function($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if($user) {
        if($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email đã được xác thực rồi!']);
        }
        
        // Xác thực email thủ công
        $user->email_verified_at = now();
        $user->save();
        
        return response()->json([
            'message' => 'Email đã được xác thực thủ công thành công!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at
            ]
        ]);
    }
    return response()->json(['error' => 'User không tồn tại']);
});

// Routes cho customer (công khai - không cần đăng nhập)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// API routes để lấy tỉnh thành, quận huyện, phường xã (công khai)
Route::get('/api/provinces', [AddressController::class, 'getProvinces'])->name('addresses.provinces');
Route::get('/api/districts/{provinceId}', [AddressController::class, 'getDistricts'])->name('addresses.districts');
Route::get('/api/wards/{districtId}', [AddressController::class, 'getWards'])->name('addresses.wards');

// Routes cho giỏ hàng (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    
    // Routes cho quản lý địa chỉ
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
    
    // API route để lấy danh sách địa chỉ (cho checkout)
    Route::get('/api/addresses', [AddressController::class, 'getAddresses'])->name('addresses.api');
    
    // Routes cho quản lý đơn hàng
    Route::get('/orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\User\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\User\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/reorder', [App\Http\Controllers\User\OrderController::class, 'reorder'])->name('orders.reorder');
    Route::get('/orders/{order}/review', [App\Http\Controllers\User\OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/{order}/review', [App\Http\Controllers\User\OrderController::class, 'storeReview'])->name('orders.store-review');
});

// Routes cho thanh toán
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index')->middleware('check.cart');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store')->middleware('check.cart');
Route::get('/checkout/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Routes cho admin (cần đăng nhập và quyền admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Quản lý danh mục - sử dụng method adminIndex cho index
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Quản lý sản phẩm - sử dụng method adminIndex cho index
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Quản lý tin tức
    Route::get('/news', [App\Http\Controllers\AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [App\Http\Controllers\AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news', [App\Http\Controllers\AdminNewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [App\Http\Controllers\AdminNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [App\Http\Controllers\AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [App\Http\Controllers\AdminNewsController::class, 'destroy'])->name('news.destroy');
});