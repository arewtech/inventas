<?php

namespace App\Http\Controllers;

use App\Models\TransferOut;
use Illuminate\Http\Request;

class TransferOutSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.letters.create-transfer-out');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string',
            'class' => 'required|string',
            'nisn' => 'required|string|max:20',
            'student_address' => 'required|string',
            'destination_school' => 'required|string|max:255',
            'reason' => 'required|string'
        ]);

        TransferOut::create([
            'user_id' => auth()->id(),
            'letter' => 'Surat Keterangan Mutasi Keluar',
            'type' => 'transfer_out',
            'student_name' => $request->student_name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'class' => $request->class,
            'nisn' => $request->nisn,
            'student_address' => $request->student_address,
            'destination_school' => $request->destination_school,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return redirect()->route('histories-site')->with([
            'success' => 'Surat berhasil dibuat, tunggu konfirmasi dari admin',
            'scrollTo' => 'scrollLetters'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransferOut $transferOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferOut $transferOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferOut $transferOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferOut $transfer_out_site)
    {
        if ($transfer_out_site->user_id !== auth()->id()) {
            abort(403);
        }

        $transfer_out_site->delete();

        return back()->with('success', 'Surat berhasil dihapus');
    }
}
