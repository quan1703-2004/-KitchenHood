<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Throwable;

class SocialAuthController extends Controller
{
    // GOOGLE
    public function redirectToGoogle()
    {
        return app(\Laravel\Socialite\Contracts\Factory::class)
            ->driver('google')
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        // Chuẩn bị HTTP client cho Socialite, fix lỗi SSL cURL 60 ở môi trường local (Windows/MAMP)
        $httpOptions = [];
        if (app()->environment('local')) {
            // Cảnh báo: chỉ vô hiệu hóa verify trong môi trường local để debug
            $httpOptions['verify'] = false;
        }

        $provider = app(\Laravel\Socialite\Contracts\Factory::class)->driver('google');
        if (!empty($httpOptions)) {
            $provider->setHttpClient(new Client($httpOptions));
        }

        try {
            $googleUser = $provider->user();
        } catch (Throwable $e) {
            // Một số môi trường (proxy, thiếu session) gây ra lỗi InvalidState

            try {
                $providerStateless = app(\Laravel\Socialite\Contracts\Factory::class)->driver('google')->stateless();
                if (!empty($httpOptions)) {
                    $providerStateless->setHttpClient(new Client($httpOptions));
                }
                $googleUser = $providerStateless->user();
            } catch (Throwable $e2) {
                return redirect()->route('login')->with('warning', 'Đăng nhập Google thất bại. Vui lòng thử lại.');
            }
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: ($googleUser->user['given_name'] ?? 'Người dùng'),
                'email' => $googleUser->getEmail(),
                // Băm mật khẩu ngẫu nhiên để an toàn hơn dù không dùng tới
                'password' => bcrypt(Str::random(32)),
                'role' => 'customer',
            ]);
        } else {
            if ($googleUser->getName()) {
                $user->name = $googleUser->getName();
            }
        }

        // Google: mặc định xác minh luôn
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user, true);

        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->intended(route('home'));
    }

    // FACEBOOK
    public function redirectToFacebook()
    {
        return app(\Laravel\Socialite\Contracts\Factory::class)
            ->driver('facebook')
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $fbUser = app(\Laravel\Socialite\Contracts\Factory::class)
                ->driver('facebook')
                ->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('warning', 'Đăng nhập Facebook thất bại. Vui lòng thử lại.');
        }

        // Email có thể không trả về với Facebook nếu app scope không xin email
        $email = method_exists($fbUser, 'getEmail') ? $fbUser->getEmail() : null;

        // Tạo user theo email nếu có, nếu không có email thì tạo theo một email giả định duy nhất (đảm bảo unique)
        $user = null;
        if ($email) {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            $generatedEmail = $email ?: (sprintf('%s@facebook.local', $fbUser->getId() ?: Str::uuid()));
            $user = User::create([
                // Tên user dùng đúng tên hiển thị từ Facebook
                'name' => $fbUser->getName() ?: 'Người dùng Facebook',
                'email' => $generatedEmail,
                'password' => Str::random(32),
                'role' => 'customer',
            ]);
        } else {
            if ($fbUser->getName()) {
                $user->name = $fbUser->getName();
            }
        }

        // Facebook: chưa kiểm duyệt (không set email_verified_at)
        $user->save();

        Auth::login($user, true);

        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->intended(route('home'));
    }
}   