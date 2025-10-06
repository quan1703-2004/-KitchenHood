<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate đầu vào cho cài đặt liên hệ
        $validated = $request->validate([
            'contact_email' => ['required','email','max:255'],
            'contact_phone' => ['nullable','string','max:50'],
            'contact_address' => ['nullable','string','max:255'],
            'contact_map_embed' => ['nullable','string'],
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return back()->with('success', 'Đã lưu cài đặt liên hệ thành công.');
    }
}


