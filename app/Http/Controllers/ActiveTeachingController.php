<?php

namespace App\Http\Controllers;

use App\Models\ActiveTeaching;
use Illuminate\Http\Request;

class ActiveTeachingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $active_teachings = ActiveTeaching::with(['user', 'responseBy']);

        if ($request->filled('status')) {
            $active_teachings->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $active_teachings->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            });
        }

        return view('dashboard.letters.active-teachings.index', ['active_teachings' => $active_teachings->latest()->paginate(setting("app_pagination") ?? 10)]);
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
    public function show(ActiveTeaching $activeTeaching)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActiveTeaching $activeTeaching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActiveTeaching $activeTeaching)
    {
        $newStatus = $activeTeaching->status === 'approved' ? 'pending' : 'approved';
        if ($activeTeaching->number == null) {
            return back()->with('error', 'Nomor surat belum di isi!');
        }
        $activeTeaching->update([
            'response_by' => auth()->id(),
            'status' => $newStatus
        ]);
        return back()->with('success', 'Status berhasil diubah menjadi ' . $newStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActiveTeaching $activeTeaching)
    {
        $activeTeaching->delete();
        return back()->with('success', 'Surat keterangan aktif mengajar berhasil dihapus');
    }

    public function updateNumber(Request $request, ActiveTeaching $activeTeaching)
    {
        try {
            $request->validate([
                'number' => 'required|string|unique:active_teachings,number,' . $activeTeaching->id
            ], [
                'number.required' => 'Nomor surat harus diisi',
                'number.unique' => 'Nomor surat sudah digunakan'
            ]);

            $activeTeaching->update([
                'number' => $request->number
            ]);

            return back()->with('success', 'Nomor surat berhasil di update');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('modal_error_id', $activeTeaching->id);
        }
    }
}
