<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\DocumentAI\Controllers\IdentificationDocumentAiController;
use Modules\DocumentAI\Controllers\TypeDocumentAiController;

Route::middleware('auth')->group(function () {
    Route::prefix('document-ai')->group(function () {
        Route::post('/type', [TypeDocumentAiController::class, 'getType']);
        Route::post('/cpf', [IdentificationDocumentAiController::class, 'getCpf']);
        Route::post('/identity', [IdentificationDocumentAiController::class, 'getIdentity']);
        Route::post('/cnh', [IdentificationDocumentAiController::class, 'getCnh']);
    });
});
