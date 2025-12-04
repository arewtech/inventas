<?php

use App\Http\Controllers\AssetBorrowingController;
use App\Http\Controllers\FrontsideController;
use App\Http\Controllers\TransferIncomingCertificateSiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransferIncomingCertificateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [FrontsideController::class, 'index'])->name('home');
Route::get('faq', [FrontsideController::class, 'faqSite'])->name('faq-site');
// Route::get('/profile', [ProfileSiteController::class, 'index'])->name('profile-site')->middleware(['auth', 'isUser']);
// Route::get('/histories', [HistorySiteController::class, 'index'])->name('histories-site')->middleware(['auth', 'isUser']);
// Route::get('/change-password', [FrontsideController::class, 'changePasswordSite'])->name('change-password-site')->middleware(['auth', 'isUser']);
Route::get('/letters', [FrontsideController::class, 'letterSite'])->name('letters-site')->middleware('auth');
Route::middleware('auth')->group(function () {
Route::resource('transfer-incoming-certificate-site', TransferIncomingCertificateSiteController::class);
});
// Route::redirect('/', '/dashboard');
Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('assets', AssetController::class);
    Route::get('/asset-borrowings/location/{location}/assets', [AssetBorrowingController::class, 'getAssetsByLocation'])->name('asset-borrowings.assets-by-location');
    Route::resource('asset-borrowings', AssetBorrowingController::class);
    Route::resource('operator', OperatorController::class);
    Route::put('asset-borrowings/{assetBorrowing}/return', [AssetBorrowingController::class, 'return'])->name('asset-borrowings.return');
    Route::get('/assets/{asset}/print-qr', [AssetController::class, 'printQr'])->name('assets.print-qr');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/assets', [ReportController::class, 'assetsReport'])->name('reports.assets');
    Route::get('/reports/asset-borrowings', [ReportController::class, 'assetBorrowingsReport'])->name('reports.asset-borrowings');
    Route::get('/app-settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::post('/app-settings', [SettingController::class, 'store'])->name('settings.store');
});

Route::get('/asset/{asset}/view', [FrontsideController::class, 'publicView'])->name('assets.public.view');
