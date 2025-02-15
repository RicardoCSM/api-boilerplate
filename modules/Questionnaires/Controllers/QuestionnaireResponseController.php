<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Questionnaires\Actions\CreateQuestionnaireResponse;
use Modules\Questionnaires\Actions\FetchQuestionnaireResponse;
use Modules\Questionnaires\Actions\FetchQuestionnaireResponsesList;
use Modules\Questionnaires\DTOs\CreateQuestionnaireResponseDTO;
use Modules\Questionnaires\Resources\QuestionnaireResponseResource;

final class QuestionnaireResponseController extends Controller
{
    public function index(DatatableDTO $dto, FetchQuestionnaireResponsesList $action): JsonResponse
    {
        return QuestionnaireResponseResource::collection($action->handle($dto))->response();
    }

    public function store(CreateQuestionnaireResponseDTO $dto, CreateQuestionnaireResponse $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new QuestionnaireResponseResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function show(string $uuid, FetchQuestionnaireResponse $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new QuestionnaireResponseResource($action->handle($uuid)));
    }
}
