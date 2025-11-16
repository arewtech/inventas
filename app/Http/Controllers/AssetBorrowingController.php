<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetBorrowing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetBorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AssetBorrowing::with(['asset', 'user']);

        if($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                    ->orWhere('borrower_phone', 'like', "%{$search}%")
                    ->orWhereHas('asset', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        if($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10);

        return view('dashboard.asset-borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('dashboard.asset-borrowings.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'asset_id' => 'required|exists:assets,id',
            'quantity' => 'required|integer|min:1',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'required|string|max:20',
            'borrower_address' => 'nullable|string',
            'borrowed_at' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:borrowed_at',
            'notes' => 'nullable|string',
        ]);

        // Check if requested quantity is available
        $asset = Asset::findOrFail($request->asset_id);

        // Additional check: ensure asset belongs to selected location
        if ($asset->location_id != $request->location_id) {
            return back()->withErrors(['asset_id' => 'Aset yang dipilih tidak sesuai dengan lokasi yang dipilih.'])->withInput();
        }

        if ($asset->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Jumlah yang diminta melebihi stok yang tersedia.'])->withInput();
        }

        // Reduce asset quantity
        $asset->quantity -= $request->quantity;
        $asset->save();

        // Create borrowing record
        $borrowing = new AssetBorrowing();
        $borrowing->asset_id = $request->asset_id;
        $borrowing->quantity = $request->quantity;
        $borrowing->borrower_name = $request->borrower_name;
        $borrowing->borrower_phone = $request->borrower_phone;
        $borrowing->borrower_address = $request->borrower_address;
        $borrowing->borrowed_at = $request->borrowed_at;
        $borrowing->expected_return_date = $request->expected_return_date;
        $borrowing->status = 'borrowed';
        $borrowing->notes = $request->notes;
        $borrowing->user_id = Auth::id();
        $borrowing->save();

        return redirect()->route('asset-borrowings.index')->with('success', 'Peminjaman aset berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetBorrowing $assetBorrowing)
    {
        $assetBorrowing->load(['asset', 'user']);
        return view('dashboard.asset-borrowings.show', compact('assetBorrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetBorrowing $assetBorrowing)
    {
        $locations = Location::all();
        $assets = Asset::where('location_id', $assetBorrowing->asset->location_id)->get();
        return view('dashboard.asset-borrowings.edit', compact('assetBorrowing', 'assets', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetBorrowing $assetBorrowing)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'asset_id' => 'required|exists:assets,id',
            'quantity' => 'required|integer|min:1',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'required|string|max:20',
            'borrower_address' => 'nullable|string',
            'expected_return_date' => 'required|date',
            'actual_return_date' => 'nullable|date',
            'status' => 'required|in:borrowed,returned,lost',
            'notes' => 'nullable|string',
        ]);

        // Check if asset belongs to selected location
        $newAsset = Asset::findOrFail($request->asset_id);
        if ($newAsset->location_id != $request->location_id) {
            return back()->withErrors(['asset_id' => 'Aset yang dipilih tidak sesuai dengan lokasi yang dipilih.'])->withInput();
        }

        $oldStatus = $assetBorrowing->status;
        $newStatus = $request->status;
        $oldAsset = $assetBorrowing->asset;

        // Handle asset changes
        if ($assetBorrowing->asset_id != $request->asset_id) {
            // If asset is changed, return quantity to old asset and deduct from new asset
            if ($oldStatus == 'borrowed') {
                $oldAsset->quantity += $assetBorrowing->quantity;
                $oldAsset->save();

                $newAsset->quantity -= $request->quantity;
                $newAsset->save();
            }

            // Update asset_id
            $assetBorrowing->asset_id = $request->asset_id;
        }

        // Handle asset quantity changes based on status change
        if ($oldStatus != $newStatus) {
            $currentAsset = Asset::findOrFail($assetBorrowing->asset_id);

            // If status changed to returned, increase asset quantity
            if ($newStatus == 'returned' && $oldStatus != 'returned') {
                $currentAsset->quantity += $assetBorrowing->quantity;
                $currentAsset->save();
            }

            // If status changed from returned to something else, decrease asset quantity
            else if ($oldStatus == 'returned' && $newStatus != 'returned') {
                $currentAsset->quantity -= $assetBorrowing->quantity;
                $currentAsset->save();
            }
        }

        // Update borrowing record
        $assetBorrowing->quantity = $request->quantity;
        $assetBorrowing->borrower_name = $request->borrower_name;
        $assetBorrowing->borrower_phone = $request->borrower_phone;
        $assetBorrowing->borrower_address = $request->borrower_address;
        $assetBorrowing->expected_return_date = $request->expected_return_date;
        $assetBorrowing->actual_return_date = $request->actual_return_date;
        $assetBorrowing->status = $request->status;
        $assetBorrowing->notes = $request->notes;
        $assetBorrowing->user_id = Auth::id();
        $assetBorrowing->save();

        return redirect()->route('asset-borrowings.index')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetBorrowing $assetBorrowing)
    {
        // If the item is borrowed, return the quantity to asset
        if ($assetBorrowing->status == 'borrowed') {
            $asset = $assetBorrowing->asset;
            $asset->quantity += $assetBorrowing->quantity;
            $asset->save();
        }

        $assetBorrowing->delete();
        return redirect()->route('asset-borrowings.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }

    /**
     * Mark borrowing as returned
     */
    public function return(AssetBorrowing $assetBorrowing)
    {
        if ($assetBorrowing->status != 'returned') {
            // Update asset quantity
            $asset = $assetBorrowing->asset;
            $asset->quantity += $assetBorrowing->quantity;
            $asset->save();

            // Update borrowing status
            $assetBorrowing->status = 'returned';
            $assetBorrowing->actual_return_date = now();
            $assetBorrowing->save();

            return redirect()->route('asset-borrowings.show', $assetBorrowing)->with('success', 'Aset berhasil dikembalikan!');
        }

        return redirect()->route('asset-borrowings.show', $assetBorrowing)->with('error', 'Aset sudah dikembalikan sebelumnya.');
    }

    /**
     * Get assets by location via AJAX
     */
    public function getAssetsByLocation($location)
    {
        if (!$location) {
            return response()->json([]);
        }

        $assets = Asset::where('location_id', $location)
            ->where('quantity', '>', 0)
            ->select('id', 'name', 'quantity', 'asset_number')
            ->get();

        return response()->json($assets);
    }
}
