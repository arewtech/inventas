<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
    }
    public function store(Request $request) {
        $data = $request->except("_token");
        if ($request->hasFile('app_logo')) {
            if (settings('app_logo')) {
                Storage::delete('public/' . settings('app_logo'));
            }
            $data['app_logo'] = $request->file('app_logo')->store('images/settings', 'public');
        } else {
            $data['app_logo'] = settings('app_logo');
        }
        // return $data;
        settings()->set($data);
        return back()->with('success', 'Pengaturan berhasil diubah');
    }
}
