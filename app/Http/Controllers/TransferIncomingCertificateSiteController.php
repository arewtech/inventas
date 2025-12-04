<?php

namespace App\Http\Controllers;

use App\Models\TransferIncomingCertificate;
use Illuminate\Http\Request;

class TransferIncomingCertificateSiteController extends Controller
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
        return view('pages.letters.create-surat-mutasi-terima');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'exists:users,id',
            'response_by' => 'nullable|exists:users,id',
            'student_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'religion' => 'required|string|max:100',
            'class' => 'required|string|max:50',
            'previous_school' => 'required|string|max:255',
            'student_address' => 'required|string|max:500',
        ]);
        $data['user_id'] = auth()->id();
        $data['letter'] = 'Surat Keterangan Mutasi Terima';
        // $data['slug'] = str($data['letter'] . '-' . str()->random(5) . '-' . rand(1000, 9999))->slug()->lower();
        $data['type'] = 'transfer_incoming';
        dd($data);
        TransferIncomingCertificate::create($data);
        return redirect()->route('histories-site')->with('success', 'Surat penghasilan berhasil diajukan')->with('scrollTo', 'scrollLetters');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransferIncomingCertificate $transfer_incoming_certificate_site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferIncomingCertificate $transfer_incoming_certificate_site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferIncomingCertificate $transfer_incoming_certificate_site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferIncomingCertificate $transfer_incoming_certificate_site)
    {
        $transfer_incoming_certificate_site->delete();
        return back()->with('success', 'Surat penghasilan berhasil dihapus')->with('scrollTo', 'scrollLetters');
    }
}
