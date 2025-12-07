<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetBorrowing;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('dashboard.reports.index', compact('categories', 'locations'));
    }

    /**
     * Generate assets report
     */
    public function assetsReport(Request $request)
    {
        $query = Asset::with(['category', 'location']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $assets = $query->get();

        return view('dashboard.reports.print-assets', compact('assets'));
    }

    /**
     * Generate asset borrowings report
     */
    public function assetBorrowingsReport(Request $request)
    {
        $query = AssetBorrowing::with(['asset.location', 'user']);

        if ($request->filled('location_id_borrowing')) {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('location_id', $request->location_id_borrowing);
            });
        }

        if ($request->filled('asset_id')) {
            $query->where('asset_id', $request->asset_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('borrowed_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->get();

        return view('dashboard.reports.print-asset-borrowings', compact('borrowings'));
    }
}
