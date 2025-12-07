<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class FrontsideController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function faqSite()
    {
        return view('pages.faq.index');
    }

    public function letterSite()
    {
        return view('pages.letters.index');
    }

    public function changePasswordSite()
    {
        return view('pages.change-password');
    }

    public function publicView(Asset $asset)
    {
        // dd($asset);
        return view('pages.public-view', compact('asset'));
    }
}
