<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function profile(Request $request)
    {
        return view('dashboard.profiles.index');
    }

    public function siteProfile(Request $request)
    {
        return view('pages.profile');
    }
}
