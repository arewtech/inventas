<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistorySiteController extends Controller
{
    public function index(Request $request)
    {
        // return $user;
        $user = auth()->user()->load(['transferIns']);
        $combinedHistories = collect($user->transferIns)
        // ->concat($user->businessDomicileCertificates)
        // ->concat($user->birthCertificates)
        // ->concat($user->deathCertificates)
        // ->concat($user->businessCertificates)
        ->sortByDesc('created_at')
        ->values();
        // $incomeCertificatesHistories = IncomeCertificate::whereUserId(auth()->id())->orderBy('created_at', 'desc')->get();
        // return $combinedHistories;
        return view('pages.histories',
            [
                'combinedHistories' => $combinedHistories
            ]
        );
    }
}
