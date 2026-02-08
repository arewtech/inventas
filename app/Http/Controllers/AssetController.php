<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource (grouped by name, category, location).
     */
    public function index(Request $request)
    {
        $query = Asset::selectRaw('
                MIN(id) as id,
                name,
                category_id,
                location_id,
                COUNT(*) as total_assets,
                SUM(CASE WHEN `condition` = "baik" THEN 1 ELSE 0 END) as total_baik,
                SUM(CASE WHEN `condition` = "rusak" THEN 1 ELSE 0 END) as total_rusak,
                SUM(CASE WHEN `condition` = "perbaikan" THEN 1 ELSE 0 END) as total_perbaikan,
                MAX(image) as image,
                MAX(created_at) as created_at
            ')
            ->with(['category', 'location'])
            ->groupBy('name', 'category_id', 'location_id');

        // Filter by search query
        if($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by location
        if($request->has('location') && $request->location != '') {
            $query->where('location_id', $request->location);
        }

        // Filter by category
        if($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $assets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('dashboard.assets.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     * Creates individual asset records based on quantity.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|string|in:baik,rusak',
            'location_id' => 'required|exists:locations,id',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quantity = $request->quantity;
        $imagePath = null;

        // Handle image upload once
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/assets', 'public');
        }

        $baseUrl = env('APP_URL', 'http://localhost');
        $createdAssets = [];

        // Create individual assets based on quantity
        for ($i = 0; $i < $quantity; $i++) {
            $assetNumber = Asset::generateAssetNumber();

            $asset = Asset::create([
                'name' => $request->name,
                'asset_number' => $assetNumber,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'location_id' => $request->location_id,
                'quantity' => 1, // Each row represents 1 physical asset
                'condition' => $request->condition,
                'image' => $imagePath,
                'additional_info' => $request->additional_info,
            ]);

            // Generate unique QR code for each asset
            $assetUrl = $baseUrl . '/asset/' . $asset->asset_number . '/view';
            $asset->qr_code = $assetUrl;
            $asset->save();

            $createdAssets[] = $asset;
        }

        // Get the first created asset to redirect to its detail page
        $firstAsset = $createdAssets[0];

        return redirect()->route('assets.show', $firstAsset->id)
            ->with('success', "Berhasil menambahkan {$quantity} aset baru");
    }

    /**
     * Display the specified grouped asset.
     */
    public function show($id)
    {
        // Find the specific asset by ID
        $asset = Asset::with(['category', 'location'])->findOrFail($id);

        // Get grouped summary for assets with same name, category, and location
        $groupedAsset = Asset::selectRaw('
                name,
                category_id,
                location_id,
                COUNT(*) as total_assets,
                SUM(CASE WHEN `condition` = "baik" THEN 1 ELSE 0 END) as total_baik,
                SUM(CASE WHEN `condition` = "rusak" THEN 1 ELSE 0 END) as total_rusak,
                SUM(CASE WHEN `condition` = "perbaikan" THEN 1 ELSE 0 END) as total_perbaikan,
                MAX(image) as image,
                MAX(description) as description,
                MAX(additional_info) as additional_info,
                MAX(qr_code) as qr_code,
                MAX(created_at) as created_at
            ')
            ->where('name', $asset->name)
            ->where('category_id', $asset->category_id)
            ->where('location_id', $asset->location_id)
            ->with(['category', 'location'])
            ->groupBy('name', 'category_id', 'location_id')
            ->first();

        if (!$groupedAsset) {
            return redirect()->route('assets.index')->with('error', 'Aset tidak ditemukan');
        }

        // Get individual assets in this group
        $individualAssets = Asset::where('name', $asset->name)
            ->where('category_id', $asset->category_id)
            ->where('location_id', $asset->location_id)
            ->with(['category', 'location'])
            ->latest()
            ->paginate(10);

        return view('dashboard.assets.show', compact('groupedAsset', 'individualAssets'));
    }

    /**
     * Show the form for editing the grouped asset.
     */
    public function edit($id)
    {
        // Get the asset by ID
        $asset = Asset::with(['category', 'location'])->findOrFail($id);

        $categories = Category::all();
        $locations = Location::all();

        return view('dashboard.assets.edit', compact('asset', 'categories', 'locations'));
    }

    /**
     * Update the grouped asset (updates all assets in the group).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Find the asset being edited
        $asset = Asset::findOrFail($id);

        // Get old values for finding the group
        $oldName = $asset->name;
        $oldCategory = $asset->category_id;
        $oldLocation = $asset->location_id;

        // Find all assets in the group
        $assets = Asset::where('name', $oldName)
            ->where('category_id', $oldCategory)
            ->where('location_id', $oldLocation)
            ->get();

        if ($assets->isEmpty()) {
            return redirect()->route('assets.index')->with('error', 'Aset tidak ditemukan');
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'location_id' => $request->location_id,
            'additional_info' => $request->additional_info,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $oldImage = $assets->first()->image;
            $imagePath = $request->file('image')->store('images/assets', 'public');
            $updateData['image'] = $imagePath;

            // Delete old image if exists
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Update all assets in the group
        Asset::where('name', $oldName)
            ->where('category_id', $oldCategory)
            ->where('location_id', $oldLocation)
            ->update($updateData);

        return redirect()->route('assets.show', $id)
            ->with('success', 'Aset berhasil diperbarui');
    }

    /**
     * Delete all assets in a group.
     */
    public function destroy($id)
    {
        // Find the asset by ID
        $asset = Asset::findOrFail($id);

        // Get the group identifiers
        $name = $asset->name;
        $category_id = $asset->category_id;
        $location_id = $asset->location_id;

        // Find all assets in the group
        $assets = Asset::where('name', $name)
            ->where('category_id', $category_id)
            ->where('location_id', $location_id)
            ->get();

        if ($assets->isEmpty()) {
            return redirect()->route('assets.index')->with('error', 'Grup aset tidak ditemukan');
        }

        $totalDeleted = $assets->count();

        // Get the image path before deletion (for cleanup)
        $imagePath = $assets->first()->image;

        // Delete all maintenance records for these assets
        foreach ($assets as $groupAsset) {
            $groupAsset->maintenances()->delete();
        }

        // Delete all assets in the group
        Asset::where('name', $name)
            ->where('category_id', $category_id)
            ->where('location_id', $location_id)
            ->delete();

        // Delete image if exists (shared by all assets in group)
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('assets.index')
            ->with('success', "Berhasil menghapus {$totalDeleted} aset dalam grup");
    }

    /**
     * Scan QR code and display asset information
     */
    public function scanQrCode($id)
    {
        $asset = Asset::with('category')->findOrFail($id);

        // Create a human-readable message
        $message = "Asset/Product: {$asset->name}\n";
        $message .= "Asset Number: {$asset->asset_number}\n";
        $message .= "Qty: {$asset->quantity}\n";
        $message .= "Location: {$asset->location}\n";
        $message .= "Category: {$asset->category->name}\n";

        if (!empty($asset->additional_info)) {
            $message .= "Additional Info: {$asset->additional_info}\n";
        }

        return response()->json([
            'asset' => $asset,
            'message' => $message
        ]);
    }
}
