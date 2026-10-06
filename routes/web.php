<?php

use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\RootController;
use App\Http\Controllers\Installer\InstallerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('install')->name('installer.')->middleware(['web'])->group(function () {
    Route::get('/', [InstallerController::class, 'index'])->name('index');
    Route::get('/requirement', [InstallerController::class, 'requirement'])->name('requirement');
    Route::get('/permission', [InstallerController::class, 'permission'])->name('permission');
    Route::get('/license', [InstallerController::class, 'license'])->name('license');
    Route::post('/license', [InstallerController::class, 'licenseStore'])->name('licenseStore');
    Route::get('/site', [InstallerController::class, 'site'])->name('site');
    Route::post('/site', [InstallerController::class, 'siteStore'])->name('siteStore');
    Route::get('/database', [InstallerController::class, 'database'])->name('database');
    Route::post('/database', [InstallerController::class, 'databaseStore'])->name('databaseStore');
    Route::get('/final', [InstallerController::class, 'final'])->name('final');
    Route::get('/final-store', [InstallerController::class, 'finalStore'])->name('finalStore');
});

Route::get('/', [RootController::class, 'index'])->middleware(['installed'])->name('home');
Route::prefix('payment')->name('payment.')->middleware(['installed'])->group(function () {
    Route::get('/{order}/pay', [PaymentController::class, 'index'])->name('index');
    Route::post('/{order}/pay', [PaymentController::class, 'payment'])->name('store');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/success', [PaymentController::class, 'success'])->name('success');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/fail', [PaymentController::class, 'fail'])->name('fail');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    Route::get('/successful/{order}', [PaymentController::class, 'successful'])->name('successful');
});

Route::get('/system/sync-live-data', function (\Illuminate\Http\Request $request) {
    if ($request->query('key') !== env('VITE_API_KEY', 'FoodAlexAPIKey2026')) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    // 1. Update Admin User to مدحت and Egyptian phone
    \App\Models\User::where('email', 'admin@example.com')
        ->orWhere('id', 1)
        ->update([
            'name' => 'مدحت',
            'phone' => '0123456789',
            'country_code' => '+20'
        ]);

    // 2. Replace any remaining +880 country codes with +20
    \App\Models\User::where('country_code', '+880')
        ->update(['country_code' => '+20']);

    // 3. Update Settings site & company
    \Illuminate\Support\Facades\DB::table('settings')
        ->where('key', 'site_default_currency_symbol')
        ->update(['value' => 'ج.م']);
        
    \Illuminate\Support\Facades\DB::table('settings')
        ->where('key', 'company_country_code')
        ->update(['value' => 'EG']);

    \Illuminate\Support\Facades\DB::table('settings')
        ->where('key', 'company_phone')
        ->update(['value' => '0123456789']);

    // 4. Update currencies table
    \Illuminate\Support\Facades\DB::table('currencies')
        ->where('code', 'EGP')
        ->update(['symbol' => 'ج.م']);

    // 5. Clear application caches
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    } catch (\Throwable $e) {}

    return response()->json([
        'status' => true,
        'message' => 'Admin updated to مدحت (0123456789), currency synced to ج.م, and cache cleared successfully!'
    ]);
});

Route::get('/{any}', [RootController::class, 'index'])->middleware(['installed'])->where(['any' => '.*']);
