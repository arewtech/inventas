<?php

namespace App\Http\Controllers;

use App\Charts\AssetBorrowingsChart;
use App\Charts\CategoriesChart;
use App\Models\Asset;
use App\Models\AssetBorrowing;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CategoriesChart $categoriesChart, AssetBorrowingsChart $assetBorrowingsChart)
    {
        // Count for top cards
        $data['categoryCount'] = Category::count();
        $data['assetCount'] = Asset::count();

        // Categories chart data
        $categories = Category::all();
        $categoryData = [];
        $categoryLabels = [];

        foreach ($categories as $category) {
            $assetCount = Asset::where('category_id', $category->id)->count();
            $categoryData[] = $assetCount;
            $categoryLabels[] = $category->name;
        }

        // Asset borrowings chart data
        $borrowingStatusData = [
            AssetBorrowing::where('status', 'borrowed')->count(),
            AssetBorrowing::where('status', 'returned')->count(),
            AssetBorrowing::where('status', 'lost')->count(),
        ];

        $borrowingStatusLabels = ['Borrowed', 'Returned', 'Lost'];

        // Total borrowings
        $data['totalBorrowings'] = array_sum($borrowingStatusData);

        // Build charts
        $data['categoriesChart'] = $categoriesChart->build($categoryData, $categoryLabels);
        $data['borrowingsChart'] = $assetBorrowingsChart->build($borrowingStatusData, $borrowingStatusLabels);

        return view('dashboard.index', $data);
    }
}
