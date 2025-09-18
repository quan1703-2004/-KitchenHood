<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SocialAuthController extends Controller
{
    /**
     * Tạo HTTP client với SSL options phù hợp cho development
     */
    private function createHttpClient()
    {
        return Http::withOptions([
            'verify' => false, // Disable SSL verification cho development
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);
    }

    /**
     * Gửi HTTP request với SSL context phù hợp cho development
     */
    private function makeHttpRequest($url, $data = null, $headers = [])
    {
        $context = stream_context_create([
            'http' => [
                'method' => $data ? 'POST' : 'GET',
                'header' => array_merge([
                    'Content-Type: application/x-www-form-urlencoded',
                ], $headers),
                'content' => $data ? http_build_query($data) : null,
                'timeout' => 30,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            throw new \Exception('HTTP request failed');
        }

        return [
            'body' => $response,
            'successful' => true,
            'json' => function() use ($response) {
                return json_decode($response, true);
            }
        ];
    }
    /**
     * Redirect đến Google OAuth
     */
    public function redirectToGoogle()
    {
        try {
            $clientId = config('services.google.client_id');
            $redirectUri = config('services.google.redirect');
            $scope = 'openid email profile';
            
            $authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'scope' => $scope,
                'response_type' => 'code',
                'access_type' => 'offline',
                'state' => 'google'
            ]);
            
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập Google. Vui lòng thử lại.');
        }
    }

    /**
     * Xử lý callback từ Google
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $code = $request->get('code');
            $state = $request->get('state');
            
            Log::info('Google callback received', [
                'code' => $code ? 'present' : 'missing',
                'state' => $state,
                'all_params' => $request->all()
            ]);
            
            if (!$code || $state !== 'google') {
                Log::error('Invalid Google callback parameters', [
                    'code' => $code,
                    'state' => $state
                ]);
                return redirect()->route('login')->with('error', 'Mã xác thực không hợp lệ.');
            }
            
            // Exchange code for access token
            $tokenResponse = $this->makeHttpRequest('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.google.redirect'),
            ]);
            
            if (!$tokenResponse['successful']) {
                Log::error('Google token request failed', [
                    'body' => $tokenResponse['body']
                ]);
                throw new \Exception('Không thể lấy access token từ Google');
            }
            
            $tokenData = $tokenResponse['json']();
            $accessToken = $tokenData['access_token'];
            
            Log::info('Google access token received', [
                'has_token' => !empty($accessToken)
            ]);
            
            // Get user info from Google
            $userResponse = $this->makeHttpRequest('https://www.googleapis.com/oauth2/v2/userinfo', null, [
                'Authorization: Bearer ' . $accessToken
            ]);
            
            if (!$userResponse['successful']) {
                Log::error('Google user info request failed', [
                    'body' => $userResponse['body']
                ]);
                throw new \Exception('Không thể lấy thông tin user từ Google');
            }
            
            $googleUser = $userResponse['json']();
            
            Log::info('Google user info received', [
                'user_id' => $googleUser['id'] ?? 'missing',
                'email' => $googleUser['email'] ?? 'missing',
                'name' => $googleUser['name'] ?? 'missing'
            ]);
            
            // Tìm hoặc tạo user
            $user = $this->findOrCreateUser($googleUser, 'google');
            
            // Đăng nhập user
            Auth::login($user, true);
            
            return redirect()->intended('/')->with('success', 'Đăng nhập Google thành công!');
            
        } catch (\Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập Google. Vui lòng thử lại.');
        }
    }

    /**
     * Redirect đến Facebook OAuth
     */
    public function redirectToFacebook()
    {
        try {
            $clientId = config('services.facebook.client_id');
            $redirectUri = config('services.facebook.redirect');
            $scope = 'email,public_profile';
            
            $authUrl = 'https://www.facebook.com/v18.0/dialog/oauth?' . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'scope' => $scope,
                'response_type' => 'code',
                'state' => 'facebook'
            ]);
            
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Facebook redirect error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập Facebook. Vui lòng thử lại.');
        }
    }

    /**
     * Xử lý callback từ Facebook
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            $code = $request->get('code');
            $state = $request->get('state');
            
            if (!$code || $state !== 'facebook') {
                return redirect()->route('login')->with('error', 'Mã xác thực không hợp lệ.');
            }
            
            // Exchange code for access token
            $tokenResponse = $this->createHttpClient()->post('https://graph.facebook.com/v18.0/oauth/access_token', [
                'client_id' => config('services.facebook.client_id'),
                'client_secret' => config('services.facebook.client_secret'),
                'code' => $code,
                'redirect_uri' => config('services.facebook.redirect'),
            ]);
            
            if (!$tokenResponse->successful()) {
                throw new \Exception('Không thể lấy access token từ Facebook');
            }
            
            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'];
            
            // Get user info from Facebook
            $userResponse = $this->createHttpClient()->get('https://graph.facebook.com/v18.0/me', [
                'fields' => 'id,name,email',
                'access_token' => $accessToken
            ]);
            
            if (!$userResponse->successful()) {
                throw new \Exception('Không thể lấy thông tin user từ Facebook');
            }
            
            $facebookUser = $userResponse->json();
            
            // Tìm hoặc tạo user
            $user = $this->findOrCreateUser($facebookUser, 'facebook');
            
            // Đăng nhập user
            Auth::login($user, true);
            
            return redirect()->intended('/')->with('success', 'Đăng nhập Facebook thành công!');
            
        } catch (\Exception $e) {
            Log::error('Facebook callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập Facebook. Vui lòng thử lại.');
        }
    }

    /**
     * Tìm hoặc tạo user từ social provider
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        // Tìm user theo email
        $user = User::where('email', $socialUser['email'] ?? null)->first();
        
        if ($user) {
            // Cập nhật thông tin social nếu chưa có
            if (!$user->google_id && $provider === 'google') {
                $user->google_id = $socialUser['id'];
            }
            if (!$user->facebook_id && $provider === 'facebook') {
                $user->facebook_id = $socialUser['id'];
            }
            
            // Tự động xác thực email nếu chưa được xác thực (social login đã verify)
            if (!$user->email_verified_at) {
                $user->email_verified_at = $user->created_at; // Set bằng ngày tạo tài khoản
                Log::info('Email auto-verified via social login', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'provider' => $provider,
                    'verified_at' => $user->email_verified_at
                ]);
            }
            
            $user->save();
            
            return $user;
        }
        
        // Tạo user mới
        $user = User::create([
            'name' => $socialUser['name'] ?? 'User',
            'email' => $socialUser['email'] ?? null,
            'email_verified_at' => null, // Sẽ được set sau khi tạo
            'password' => Hash::make(Str::random(16)), // Random password
            'google_id' => $provider === 'google' ? $socialUser['id'] : null,
            'facebook_id' => $provider === 'facebook' ? $socialUser['id'] : null,
        ]);
        
        // Set email_verified_at bằng ngày tạo tài khoản
        $user->email_verified_at = $user->created_at;
        $user->save();
        
        Log::info('New user created via social login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'provider' => $provider,
            'email_verified_at' => $user->email_verified_at
        ]);
        
        return $user;
    }
}
