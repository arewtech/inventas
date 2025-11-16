<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::with(['category', 'location']);

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

        $assets = $query->latest()->paginate(10);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Generate unique asset number automatically
        $data['asset_number'] = Asset::generateAssetNumber();

        // Set location name from location_id for backward compatibility
        if ($request->location_id) {
            $location = Location::find($request->location_id);
            $data['location'] = $location->name;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/assets', 'public');
            $data['image'] = $imagePath;
        }

        $asset = Asset::create($data);
        // Generate QR code with URL to public asset view
        $baseUrl = env('APP_URL', 'http://localhost');
        $assetUrl = $baseUrl . '/asset/' . $asset->asset_number . '/view';

        // Store the QR code URL in the database
        $asset->qr_code = $assetUrl;
        $asset->save();

        return redirect()->route('assets.show', $asset->asset_number)
            ->with('success', 'Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        // Generate QR code image using the stored data
        $qrCode = QrCode::size(230)->generate($asset->qr_code);

        return view('dashboard.assets.show', compact('asset', 'qrCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('dashboard.assets.edit', compact('asset', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|string|in:baik,rusak',
            'location_id' => 'required|exists:locations,id',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Remove asset_number from the data to prevent updating it
        unset($data['asset_number']);
        unset($data['qr_code']);

        // Set location name from location_id for backward compatibility
        if ($request->location_id) {
            $location = Location::find($request->location_id);
            $data['location'] = $location->name;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($asset->image) {
                Storage::disk('public')->delete($asset->image);
            }

            $imagePath = $request->file('image')->store('images/assets', 'public');
            $data['image'] = $imagePath;
        }

        $asset->update($data);

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete image if exists
        if ($asset->image) {
            Storage::disk('public')->delete($asset->image);
        }

        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil dihapus');
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

    public function printQr(Asset $asset)
    {
        // Generate QR code
        $qrCode = QrCode::size(200)
            ->generate($asset->qr_code);
        return view('dashboard.assets.print-qr', compact('asset', 'qrCode'));
    }
}
