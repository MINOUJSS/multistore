<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::all();

        return view('admins.admin.setting.index', compact('settings'));
    }

    // update google analitics code
    public function update_settings(Request $request)
    {
        // validation
        // $request->validate([
        //     'google_analitics' => 'required|string|min:10',
        // ]);
        foreach ($request->settings as $setting) {
            PlatformSetting::where('key', $setting['key'])->update([
                'value' => $setting['value'] ?? null,

                'description' => $setting['description'] ?? null,

                'status' => isset($setting['status'])
                            ? 'active'
                            : 'inactive',
            ]);
        }

        return back()->with('success', 'تم حفظ جميع الإعدادات.');
    }
}
