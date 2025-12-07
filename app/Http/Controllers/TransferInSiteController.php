<?php

namespace App\Http\Controllers;

use App\Models\TransferIn;
use Illuminate\Http\Request;

class TransferInSiteController extends Controller
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
        return view('pages.letters.create-transfer-in');
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
        $data['type'] = 'transfer_in';
        // dd($data);
        TransferIn::create($data);
        return redirect()->route('histories-site')->with('success', 'Surat penghasilan berhasil diajukan')->with('scrollTo', 'scrollLetters');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransferIn $transfer_in_site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferIn $transfer_in_site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferIn $transfer_in_site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferIn $transfer_in_site)
    {
        $transfer_in_site->delete();
        return back()->with('success', 'Surat penghasilan berhasil dihapus')->with('scrollTo', 'scrollLetters');
    }
}
