<?php

namespace App\Http\Controllers;

use App\Models\ActiveTeaching;
use Illuminate\Http\Request;

class ActiveTeachingSiteController extends Controller
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
        return view('pages.letters.create-active-teaching');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'nuptk' => 'required|string|max:20',
            'education' => 'required|string',
            'teaching_hours' => 'required|string',
            'teacher_address' => 'required|string',
            'tmt' => 'required|date'
        ]);

        ActiveTeaching::create([
            'user_id' => auth()->id(),
            'letter' => 'Surat Keterangan Aktif Mengajar',
            'type' => 'active_teaching',
            'teacher_name' => $request->teacher_name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'nuptk' => $request->nuptk,
            'education' => $request->education,
            'teaching_hours' => $request->teaching_hours,
            'teacher_address' => $request->teacher_address,
            'tmt' => $request->tmt,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActiveTeaching $active_teaching_site)
    {
        if ($active_teaching_site->user_id !== auth()->id()) {
            abort(403);
        }

        $active_teaching_site->delete();

        return back()->with('success', 'Surat berhasil dihapus');
    }
}
