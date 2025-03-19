<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(\App\Http\Controllers\DistanceController::class)->group(function () {
    Route::get('/distance', 'index')->name('distance.index');
    Route::post('/distance', 'store')->name('distance.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
});

Route::post('auth/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard
Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Configuration
Route::prefix('configurations')->as('configurations.')->middleware('auth')->group(function() {
    Route::prefix('roles')->as('roles.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\RoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('permissions')->as('permissions.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\PermissionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('menu-groups')->as('menuGroups.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\MenuGroupController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('menu-items')->as('menuItems.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\MenuItemController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('menu-sortable')->as('menuSortable.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\MenuSortableController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/update/{type}', 'update')->name('update');
            Route::get('/get/{id}', 'getById')->name('getById');
        });
    });

    Route::prefix('routes')->as('routes.')->group(function() {
        Route::controller(\App\Http\Controllers\Configuration\RouteController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/get', 'get')->name('get');
            Route::post('/', 'store')->name('store');
            Route::get('/get/{id}', 'getById')->name('getById');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });
});