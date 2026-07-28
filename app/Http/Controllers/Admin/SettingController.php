<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settingsData = $request->except('_token');

        foreach ($settingsData as $key => $value) {
            Setting::setByKey($key, $value);
        }

        ActivityLogService::log('UPDATE_SETTINGS', 'Updated system preferences.', 'Settings');

        return back()->with('success', 'System settings saved successfully.');
    }
}