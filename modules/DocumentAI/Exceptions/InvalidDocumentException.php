<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

class InvalidDocumentException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'O documento fornecido é inválido ou não pôde ser reconhecido como um documento válido para processamento de OCR.',
            Response::HTTP_BAD_REQUEST
        );
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $this->message,
        ], $this->code);
    }
}
