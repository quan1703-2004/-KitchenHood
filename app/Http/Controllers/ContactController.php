<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $settings = Setting::getSettings();
        return view('customer.contact', compact('settings'));
    }

    public function send(Request $request)
    {
        // Validate đầu vào phía server để đảm bảo an toàn
        $validated = $request->validate([
            'firstName' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'service' => ['required','string','max:100'],
            'budget' => ['nullable','string','max:100'],
            'message' => ['required','string','max:3000'],
        ]);

        // Lấy email admin từ settings, fallback ENV nếu thiếu
        $settings = Setting::getSettings();
        $adminEmail = $settings->contact_email ?: env('MAIL_FROM_ADDRESS', 'admin@example.com');

        // Gửi mail cho admin với thông tin người liên hệ
        Mail::to($adminEmail)->send(new ContactMessageMail($validated));

        return redirect()->route('contact')->with('success', 'Gửi thành công! Chúng tôi sẽ phản hồi sớm nhất.');
    }
}


