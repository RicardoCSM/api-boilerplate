<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\DocumentAI\Controllers\IdentificationDocumentAIController;
use Modules\DocumentAI\Controllers\TypeDocumentAiController;

Route::middleware('auth')->group(function () {
    Route::prefix('document-ai')->group(function () {
        Route::post('/type', [TypeDocumentAiController::class, 'getType']);
        Route::post('/cpf', [IdentificationDocumentAIController::class, 'getCpf']);
        Route::post('/identity', [IdentificationDocumentAIController::class, 'getIdentity']);
        Route::post('/cnh', [IdentificationDocumentAIController::class, 'getCnh']);
    });
});
