<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('id')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ((array) $request->input('settings', []) as $key => $val) {
            Setting::where('key', $key)->update(['value' => is_string($val) ? trim($val) : $val]);
        }

        return back()->with('success', 'Settings saved. Changes are live on the website immediately.');
    }
}
