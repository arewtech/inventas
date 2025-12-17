<?php

namespace App\Http\Controllers;

use App\Models\TransferIn;
use Illuminate\Http\Request;

class TransferInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $trasfer_ins = TransferIn::with(['user', 'responseBy']);
        // cari berdasarkan status dan kategori name
        if ($request->filled('status')) {
            $trasfer_ins->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $trasfer_ins->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            });
        }
        // return $income_certificate;
        return view('dashboard.letters.transfer-ins.index', ['transfer_ins' => $trasfer_ins->latest()->paginate(setting("app_pagination") ?? 10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TransferIn $transfer_in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferIn $transfer_in)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferIn $transfer_in)
    {
       // dd($business_certificate);
        $newStatus = $transfer_in->status === 'approved' ? 'pending' : 'approved';
        if ($transfer_in->number == null)
        { return back()->with('error', 'Nomor surat belum di isi!'); }
        $transfer_in->update([
            'response_by' => auth()->id(),
            'status' => $newStatus
        ]);
        return back()->with('success', 'Status berhasil diubah menjadi ' . $newStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferIn $transfer_in)
    {
        $transfer_in->delete();
        return back()->with('success', 'Surat penghasilan berhasil dihapus');
    }

    public function updateNumber(Request $request, TransferIn $transfer_in)
    {
        try {
            $request->validate([
                'number' => 'required|string|unique:transfer_ins,number,' . $transfer_in->id
            ], [
                'number.required' => 'Nomor surat harus diisi',
                'number.unique' => 'Nomor surat sudah digunakan'
            ]);

            $transfer_in->update([
                'number' => $request->number
            ]);

            return back()->with('success', 'Nomor surat berhasil di update');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('modal_error_id', $transfer_in->id);
        }
    }
}
