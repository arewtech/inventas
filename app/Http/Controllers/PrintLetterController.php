<?php

namespace App\Http\Controllers;

use App\Models\ActiveTeaching;
use App\Models\TransferIn;
use App\Models\TransferOut;
use Illuminate\Http\Request;

class PrintLetterController extends Controller
{
    public function incomeCertificatePrint(TransferIn $transfer_in)
    {
        $transfer_in =  $transfer_in->load(['user', 'responseBy']);
        if ($transfer_in->status == 'pending') {
            abort(404);
        }
        return view('dashboard.print.print-transfer-in', compact('transfer_in'));
    }

    public function userPrint(TransferIn $transfer_in)
    {
        // Verify the letter belongs to the authenticated user
        if ($transfer_in->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $transfer_in = $transfer_in->load(['user', 'responseBy']);

        if ($transfer_in->status == 'pending' || $transfer_in->number == null) {
            abort(404, 'Letter not ready for print');
        }

        return view('dashboard.print.print-transfer-in', compact('transfer_in'));
    }

    public function transferOutPrint(TransferOut $transfer_out)
    {
        $transfer_out = $transfer_out->load(['user', 'responseBy']);
        if ($transfer_out->status == 'pending') {
            abort(404);
        }
        return view('dashboard.print.print-transfer-out', compact('transfer_out'));
    }

    public function userPrintOut(TransferOut $transfer_out)
    {
        // Verify the letter belongs to the authenticated user
        if ($transfer_out->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $transfer_out = $transfer_out->load(['user', 'responseBy']);

        if ($transfer_out->status == 'pending' || $transfer_out->number == null) {
            abort(404, 'Letter not ready for print');
        }

        return view('dashboard.print.print-transfer-out', compact('transfer_out'));
    }

    public function activeTeachingPrint(ActiveTeaching $active_teaching)
    {
        $active_teaching = $active_teaching->load(['user', 'responseBy']);
        if ($active_teaching->status == 'pending') {
            abort(404);
        }
        return view('dashboard.print.print-active-teaching', compact('active_teaching'));
    }

    public function userPrintActiveTeaching(ActiveTeaching $active_teaching)
    {
        // Verify the letter belongs to the authenticated user
        if ($active_teaching->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $active_teaching = $active_teaching->load(['user', 'responseBy']);

        if ($active_teaching->status == 'pending' || $active_teaching->number == null) {
            abort(404, 'Letter not ready for print');
        }

        return view('dashboard.print.print-active-teaching', compact('active_teaching'));
    }
}
