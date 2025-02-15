<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Common\Logs\Controllers\AccessLogController;

Route::middleware('auth')->group(function () {
    Route::prefix('logs')->group(function () {
        Route::get('/access', [AccessLogController::class, 'index'])->can('ALL-list-access-logs');
    });
});
