<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Common\Core\Controllers\DeleteMediaController;
use Modules\Common\Core\Controllers\SignedStorageUrlController;

// Public Routes

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::delete('media/{uuid}', DeleteMediaController::class)->can('ALL-delete-media');

    Route::post('uploads/signed-storage-url', [SignedStorageUrlController::class, 'store']);
});
