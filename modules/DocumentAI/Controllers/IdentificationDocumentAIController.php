<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\DocumentAI\Actions\GetCnh;
use Modules\DocumentAI\Actions\GetCpf;
use Modules\DocumentAI\Actions\GetIdentity;
use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Resources\CnhResource;
use Modules\DocumentAI\Resources\CpfResource;
use Modules\DocumentAI\Resources\IdentityResource;

class IdentificationDocumentAiController extends Controller
{
    public function getCpf(DocumentAIDTO $dto, GetCpf $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new CpfResource($action->handle($dto))
        );
    }

    public function getIdentity(DocumentAIDTO $dto, GetIdentity $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new IdentityResource($action->handle($dto))
        );
    }

    public function getCnh(DocumentAIDTO $dto, GetCnh $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new CnhResource($action->handle($dto))
        );
    }
}
