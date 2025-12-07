<?php

use App\Http\Controllers\ActiveTeachingController;
use App\Http\Controllers\ActiveTeachingSiteController;
use App\Http\Controllers\AssetBorrowingController;
use App\Http\Controllers\FrontsideController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistorySiteController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PrintLetterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransferInController;
use App\Http\Controllers\TransferInSiteController;
use App\Http\Controllers\TransferOutController;
use App\Http\Controllers\TransferOutSiteController;

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
Route::get('/histories', [HistorySiteController::class, 'index'])->name('histories-site')->middleware(['auth']);
Route::get('/profile', [ProfileController::class, 'siteProfile'])->name('profile-site')->middleware(['auth']);
Route::get('/change-password', [FrontsideController::class, 'changePasswordSite'])->name('change-password-site')->middleware(['auth']);
// User print routes
Route::get('/letters/transfer-ins/{transfer_in}/print', [PrintLetterController::class, 'userPrintIn'])->name('letters.transfer-ins.print')->middleware(['auth']);
Route::get('/letters/transfer-outs/{transfer_out}/print', [PrintLetterController::class, 'userPrintOut'])->name('letters.transfer-outs.print')->middleware(['auth']);
Route::get('/letters/active-teachings/{active_teaching}/print', [PrintLetterController::class, 'userPrintActiveTeaching'])->name('letters.active-teachings.print')->middleware(['auth']);
Route::get('/letters', [FrontsideController::class, 'letterSite'])->name('letters-site')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('transfer-in-sites', TransferInSiteController::class);
    Route::resource('transfer-out-sites', TransferOutSiteController::class);
    Route::resource('active-teaching-sites', ActiveTeachingSiteController::class);
});
// Route::redirect('/', '/dashboard');
Route::prefix('/dashboard')->middleware(['auth', 'role:admin,operator'])->group(function () {
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
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/app-settings', [SettingController::class, 'store'])->name('settings.store');

    // letters routes
    // print routes
    Route::get('/transfer-ins/{transfer_in}/print', [PrintLetterController::class, 'transferInPrint'])->name('transfer-ins.print');
    Route::get('/transfer-outs/{transfer_out}/print', [PrintLetterController::class, 'transferOutPrint'])->name('transfer-outs.print');
    Route::get('/active-teachings/{active_teaching}/print', [PrintLetterController::class, 'activeTeachingPrint'])->name('active-teachings.print');
    // update nomer surat
    Route::put('/transfer-ins/{transfer_in}/update-number', [TransferInController::class, 'updateNumber'])->name('transfer-ins.update-number');
    Route::put('/transfer-outs/{transfer_out}/update-number', [TransferOutController::class, 'updateNumber'])->name('transfer-outs.update-number');
    Route::put('/active-teachings/{active_teaching}/update-number', [ActiveTeachingController::class, 'updateNumber'])->name('active-teachings.update-number');
    // resources
    Route::resource('transfer-ins', TransferInController::class);
    Route::resource('transfer-outs', TransferOutController::class);
    Route::resource('active-teachings', ActiveTeachingController::class);
});

// route public tanpa auth
Route::get('/asset/{asset}/view', [FrontsideController::class, 'publicView'])->name('assets.public.view');
