<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JetstreamDashboard;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

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



Route::middleware([
    'web',
    'universal',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [JetstreamDashboard::class, 'index'])->name('dashboard');
    Route::get('/token-permissions', fn (Request $request) => "User can delete: " . (string) $request->user()->tokenCan('delete'));
    Route::get('/tokens', fn (Request $request) => $request->user()->tokens);
});

Route::middleware([
    'web',
    'universal',
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id') . ' and the current user is ' . auth()?->user()?->email;
    });

    Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');
});
