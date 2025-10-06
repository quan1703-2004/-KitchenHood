<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPasswordMail;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký người dùng
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Mặc định là customer
        ]);

        // Gửi email xác thực
        $user->sendEmailVerificationNotification();

        // Lưu thông tin user vào session để hiển thị thông báo
        Session::put('registered_user', $user->email);
        Session::flash('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
        
        return redirect()->route('login');
    }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Hiển thị form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Xử lý đăng nhập người dùng
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Kiểm tra xem email đã được xác thực chưa
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                Session::flash('warning', 'Vui lòng xác thực email trước khi đăng nhập. Kiểm tra email của bạn.');
                return redirect()->route('login');
            }
            
            // Xóa session registered_user nếu có
            Session::forget('registered_user');
            
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Xử lý đăng xuất người dùng
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    // Xử lý gửi mật khẩu mới qua email (throttle 30 phút)
    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($validated['email']));

        // Throttling 30 phút theo email để tránh spam
        $cacheKey = 'forgot-password:' . $email;
        if (Cache::has($cacheKey)) {
            return back()->withErrors([
                'email' => 'Bạn quên quá nhiều lần, hãy thử lại sau 30 phút',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            // Không lộ thông tin tồn tại tài khoản
            return back()->withErrors([
                'email' => 'Email không tồn tại trong hệ thống.',
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'Email chưa được xác thực. Vui lòng xác thực email trước.',
            ]);
        }

        // Tạo mật khẩu ngẫu nhiên 8 ký tự: chữ và số
        $newPassword = $this->generateRandomPassword(8);

        // Cập nhật mật khẩu mới (hash) vào DB
        $user->password = Hash::make($newPassword);
        $user->save();

        // Gửi email mật khẩu mới
        Mail::to($email)->queue(new NewPasswordMail($newPassword));

        // Đặt throttle 30 phút
        Cache::put($cacheKey, true, now()->addMinutes(30));

        // Thông báo
        Session::flash('status', 'Chúng tôi đã gửi mật khẩu mới về email ' . $email . ' - hãy check cả thư mục spam.');
        return redirect()->route('password.request');
    }

    private function generateRandomPassword(int $length = 8): string
    {
        // Sinh mật khẩu gồm chữ hoa, chữ thường và số để tăng độ mạnh
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        $maxIndex = strlen($chars) - 1;
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $maxIndex)]; // random_int an toàn hơn mt_rand
        }
        return $result;
    }
}