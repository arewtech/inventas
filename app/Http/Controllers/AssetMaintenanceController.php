<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetMaintenanceController extends Controller
{
    /**
     * Display a listing of all individual assets.
     */
    public function index(Request $request)
    {
        $query = Asset::with(['category', 'location']);

        // Filter by name (for detail view from assets.index)
        if($request->has('name') && $request->name != '') {
            $query->where('name', $request->name);
        }

        // Filter by category
        if($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by location
        if($request->has('location') && $request->location != '') {
            $query->where('location_id', $request->location);
        }

        // Filter by search query
        if($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('asset_number', 'like', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $assets = $query->latest()->paginate(10);

        return view('dashboard.asset-maintenances.index', compact('assets'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset_maintenance)
    {
        return view('dashboard.asset-maintenances.show', compact('asset_maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset_maintenance)
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('dashboard.asset-maintenances.edit', compact('asset_maintenance', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset_maintenance)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|string|in:baik,rusak',
            'location_id' => 'required|exists:locations,id',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['asset_number', 'qr_code', 'quantity']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($asset_maintenance->image) {
                Storage::disk('public')->delete($asset_maintenance->image);
            }

            $imagePath = $request->file('image')->store('images/assets', 'public');
            $data['image'] = $imagePath;
        }

        $asset_maintenance->update($data);

        return redirect()->route('asset-maintenances.show', $asset_maintenance->asset_number)
            ->with('success', 'Aset berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset_maintenance)
    {
        // Delete image if exists and not shared with other assets
        if ($asset_maintenance->image) {
            $sharedImageCount = Asset::where('image', $asset_maintenance->image)
                ->where('id', '!=', $asset_maintenance->id)
                ->count();

            if ($sharedImageCount == 0) {
                Storage::disk('public')->delete($asset_maintenance->image);
            }
        }

        $asset_maintenance->delete();

        return redirect()->route('asset-maintenances.index')
            ->with('success', 'Aset berhasil dihapus');
    }
}
