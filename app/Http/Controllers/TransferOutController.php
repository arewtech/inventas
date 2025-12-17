<?php

namespace App\Http\Controllers;

use App\Models\TransferOut;
use Illuminate\Http\Request;

class TransferOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transfer_outs = TransferOut::with(['user', 'responseBy']);

        if ($request->filled('status')) {
            $transfer_outs->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $transfer_outs->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            });
        }

        return view('dashboard.letters.transfer-outs.index', ['transfer_outs' => $transfer_outs->latest()->paginate(setting("app_pagination") ?? 10)]);
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
    public function show(TransferOut $transfer_out)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransferOut $transfer_out)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransferOut $transfer_out)
    {
        $newStatus = $transfer_out->status === 'approved' ? 'pending' : 'approved';
        if ($transfer_out->number == null) {
            return back()->with('error', 'Nomor surat belum di isi!');
        }
        $transfer_out->update([
            'response_by' => auth()->id(),
            'status' => $newStatus
        ]);
        return back()->with('success', 'Status berhasil diubah menjadi ' . $newStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransferOut $transfer_out)
    {
        $transfer_out->delete();
        return back()->with('success', 'Surat mutasi keluar berhasil dihapus');
    }

    public function updateNumber(Request $request, TransferOut $transfer_out)
    {
        try {
            $request->validate([
                'number' => 'required|string|unique:transfer_outs,number,' . $transfer_out->id
            ], [
                'number.required' => 'Nomor surat harus diisi',
                'number.unique' => 'Nomor surat sudah digunakan'
            ]);

            $transfer_out->update([
                'number' => $request->number
            ]);

            return back()->with('success', 'Nomor surat berhasil di update');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('modal_error_id', $transfer_out->id);
        }
    }
}
