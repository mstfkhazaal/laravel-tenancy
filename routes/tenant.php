<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        if(Auth::check()){
            return redirect()->route('dashboard-tenant');
        }else{
            return redirect()->route('login');
        }
    })->name('home-tenant');
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('dashboards', function () {
            return Inertia::render('dashboard');
        })->name('dashboard-tenant');
    });

});
