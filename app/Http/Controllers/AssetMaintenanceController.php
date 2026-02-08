<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AssetMaintenanceController extends Controller
{
    /**
     * Display a listing of all maintenance records.
     */
    public function index(Request $request)
    {
        $query = AssetMaintenance::with(['asset.category', 'asset.location']);

        // Filter by asset name
        if($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->whereHas('asset', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_number', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if($request->has('category') && $request->category != '') {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Filter by location
        if($request->has('location') && $request->location != '') {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('location_id', $request->location);
            });
        }

        // Filter by condition
        if($request->has('condition') && $request->condition != '') {
            $query->where('condition', $request->condition);
        }

        $maintenances = $query->latest()->paginate(10);

        return view('dashboard.asset-maintenances.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
    public function create()
    {
        // Only show assets with 'baik' condition for new maintenance records
        $assets = Asset::with(['category', 'location'])
            ->where('condition', 'baik')
            ->get();
        return view('dashboard.asset-maintenances.create', compact('assets'));
    }

    /**
     * Store a newly created maintenance record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'condition' => 'required|string|in:baik,rusak,perbaikan',
            'nominal' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Check if asset condition is 'baik' before creating maintenance record
        $asset = Asset::findOrFail($request->asset_id);
        if ($asset->condition !== 'baik') {
            return back()->withInput()->withErrors([
                'asset_id' => 'Hanya asset dengan kondisi baik yang dapat ditambahkan ke pemeliharaan. Asset ini sudah memiliki status ' . $asset->condition . '.'
            ]);
        }

        // If condition is perbaikan, nominal is required
        if ($request->condition === 'perbaikan' && !$request->nominal) {
            return back()->withInput()->withErrors(['nominal' => 'Nominal biaya perbaikan wajib diisi untuk kondisi perbaikan']);
        }

        DB::beginTransaction();
        try {
            // Create maintenance record
            AssetMaintenance::create([
                'asset_id' => $request->asset_id,
                'condition' => $request->condition,
                'nominal' => $request->condition === 'perbaikan' ? $request->nominal : null,
                'notes' => $request->notes,
            ]);

            // Update asset condition
            $asset->update([
                'condition' => $request->condition
            ]);

            DB::commit();

            return redirect()->route('asset-maintenances.index')
                ->with('success', 'Record pemeliharaan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan record pemeliharaan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified maintenance record.
     */
    public function show(AssetMaintenance $asset_maintenance)
    {
        $asset_maintenance->load(['asset.category', 'asset.location']);
        return view('dashboard.asset-maintenances.show', compact('asset_maintenance'));
    }

    /**
     * Show the form for editing the maintenance record.
     */
    public function edit(AssetMaintenance $asset_maintenance)
    {
        $asset_maintenance->load(['asset']);
        return view('dashboard.asset-maintenances.edit', compact('asset_maintenance'));
    }

    /**
     * Update the specified maintenance record.
     */
    public function update(Request $request, AssetMaintenance $asset_maintenance)
    {
        $request->validate([
            'condition' => 'required|string|in:baik,rusak,perbaikan',
            'nominal' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // If condition is perbaikan, nominal is required
        if ($request->condition === 'perbaikan' && !$request->nominal) {
            return back()->withInput()->withErrors(['nominal' => 'Nominal biaya perbaikan wajib diisi untuk kondisi perbaikan']);
        }

        DB::beginTransaction();
        try {
            $asset_maintenance->update([
                'condition' => $request->condition,
                'nominal' => $request->condition === 'perbaikan' ? $request->nominal : null,
                'notes' => $request->notes,
            ]);

            // Update asset condition to latest maintenance condition
            $asset_maintenance->asset->update([
                'condition' => $request->condition
            ]);

            DB::commit();

            return redirect()->route('asset-maintenances.show', $asset_maintenance)
                ->with('success', 'Record pemeliharaan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui record pemeliharaan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified maintenance record.
     */
    public function destroy(AssetMaintenance $asset_maintenance)
    {
        DB::beginTransaction();
        try {
            $asset_maintenance->delete();

            // Update asset condition to latest maintenance record or default to 'baik'
            $latestMaintenance = AssetMaintenance::where('asset_id', $asset_maintenance->asset_id)
                ->latest()
                ->first();

            $asset_maintenance->asset->update([
                'condition' => $latestMaintenance ? $latestMaintenance->condition : 'baik'
            ]);

            DB::commit();

            return redirect()->route('asset-maintenances.index')
                ->with('success', 'Record pemeliharaan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus record pemeliharaan: ' . $e->getMessage()]);
        }
    }
}
