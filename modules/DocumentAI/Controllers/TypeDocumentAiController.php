<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\DocumentAI\Actions\GetType;
use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Resources\TypeResource;

class TypeDocumentAiController extends Controller
{
    public function getType(DocumentAIDTO $dto, GetType $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new TypeResource($action->handle($dto))
        );
    }
}
