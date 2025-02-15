<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Tenant\Controllers\TenantController;

Route::middleware('auth:api')->group(function () {
    Route::post('tenants', [TenantController::class, 'store']);
});
