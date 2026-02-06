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
                name,
                category_id,
                location_id,
                COUNT(*) as total_assets,
                SUM(CASE WHEN `condition` = "baik" THEN 1 ELSE 0 END) as total_baik,
                SUM(CASE WHEN `condition` = "rusak" THEN 1 ELSE 0 END) as total_rusak,
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

        return redirect()->route('asset-maintenances.index', [
                'name' => $request->name,
                'category' => $request->category_id,
                'location' => $request->location_id
            ])
            ->with('success', "Berhasil menambahkan {$quantity} aset baru");
    }

    /**
     * Display the specified resource.
     * Redirects to asset maintenance list with filters.
     */
    public function show(Request $request)
    {
        // Get filter parameters from request
        $name = $request->query('name');
        $category = $request->query('category');
        $location = $request->query('location');

        return redirect()->route('asset-maintenances.index', [
            'name' => $name,
            'category' => $category,
            'location' => $location
        ]);
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
