<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Tenant\Controllers\AdsController;
use Modules\Tenant\Controllers\BootstrapController;
use Modules\Tenant\Controllers\ThemeController;

Route::middleware('auth:api')->group(function () {
    Route::prefix('tenant')->group(function () {
        Route::get('ads', [AdsController::class, 'index']);
        Route::post('ads', [AdsController::class, 'store'])->can('ALL-create-ads');

        Route::post('ads/reorder', [AdsController::class, 'reorder']);
        Route::get('ads/{uuid}', [AdsController::class, 'show']);
        Route::put('ads/{uuid}', [AdsController::class, 'update'])->can('ALL-edit-ads');
        Route::delete('ads/{uuid}', [AdsController::class, 'destroy'])->can('ALL-delete-ads');

        Route::get('themes', [ThemeController::class, 'index']);
        Route::post('themes', [ThemeController::class, 'store'])->can('ALL-create-themes');
        Route::get('themes/{uuid}', [ThemeController::class, 'show']);
        Route::put('themes/{uuid}', [ThemeController::class, 'update'])->can('ALL-edit-themes');
        Route::delete('themes/{uuid}', [ThemeController::class, 'destroy'])->can('ALL-delete-themes');
    });
});

Route::get('tenant/bootstrap', BootstrapController::class);
