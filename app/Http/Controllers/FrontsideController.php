<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class FrontsideController extends Controller
{
    public function publicView(Asset $asset)
    {
        // dd($asset);
        return view('pages.public-view', compact('asset'));
    }
}
