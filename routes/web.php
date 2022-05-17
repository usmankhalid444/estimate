<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\FeatureController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [DashboardController::class, 'index']);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::resource('customers', CustomerController::class, ['names' => 'customers']);
    Route::resource('features', FeatureController::class, ['names' => 'features']);
    Route::post('/save-estimate', [EstimateController::class, 'store']);
    Route::get('all-estimates', [EstimateController::class, 'index']);
});



require __DIR__ . '/auth.php';
