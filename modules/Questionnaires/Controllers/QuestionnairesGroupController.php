<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;
use Modules\Questionnaires\Actions\CreateQuestionnairesGroup;
use Modules\Questionnaires\Actions\DeleteQuestionnairesGroup;
use Modules\Questionnaires\Actions\FetchQuestionnairesGroup;
use Modules\Questionnaires\Actions\FetchQuestionnairesGroupsList;
use Modules\Questionnaires\Actions\UpdateQuestionnairesGroup;
use Modules\Questionnaires\DTOs\CreateQuestionnairesGroupDTO;
use Modules\Questionnaires\DTOs\UpdateQuestionnairesGroupDTO;
use Modules\Questionnaires\Resources\QuestionnairesGroupResource;

final class QuestionnairesGroupController extends Controller
{
    public function index(DatatableDTO $dto, FetchQuestionnairesGroupsList $action): JsonResponse
    {
        return QuestionnairesGroupResource::collection($action->handle($dto))->response();
    }

    public function show(string $uuid, FetchQuestionnairesGroup $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new QuestionnairesGroupResource($action->handle($uuid)));
    }

    public function store(CreateQuestionnairesGroupDTO $dto, CreateQuestionnairesGroup $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new QuestionnairesGroupResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateQuestionnairesGroupDTO $dto, string $uuid, UpdateQuestionnairesGroup $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new QuestionnairesGroupResource($action->handle($uuid, $dto)));
    }

    public function destroy(string $uuid, DeleteQuestionnairesGroup $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }
}
