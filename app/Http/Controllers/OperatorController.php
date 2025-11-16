<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['isAdmin'])->except(['index','show']);
    // }
    public function index()
    {
        return view('dashboard.operator.index',[
            'operators' => User::where('id', '!=', auth()->id())->where('role', '!=', 'admin')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 'operator') {
            return abort(404);
        }
        return view('dashboard.operator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users', 'alpha'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'min:10', 'max:13'],
            'role' => ['string', 'in:operator'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'operator';
        User::create($data);

        return redirect()->route('operator.index')->with('success', 'Operator berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $operator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $operator)
    {
        if (auth()->user()->role == 'operator') {
            return abort(404);
        }
        // return $operator;
        return view('dashboard.operator.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $operator)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'alpha'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['required', 'string', 'min:10', 'max:13'],
            'status' => ['nullable'],
        ]);

        if ($request->password) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['status'] = $request->has('status') ? 'active' : 'inactive';
        // dd($data);
        $operator->update($data);

        return redirect()->route('operator.index')->with('success', 'Data operator berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $operator)
    {
        if (auth()->user()->role == 'operator') {
            return abort(404);
        }
        // delete image avatar
        if ($operator->avatar) {
            Storage::delete($operator->avatar);
        }
        $operator->delete();
        return back()->with('success', 'Operator berhasil dihapus');
    }
}
