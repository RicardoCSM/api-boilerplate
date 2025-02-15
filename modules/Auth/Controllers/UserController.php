<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Modules\Auth\Actions\CreateUser;
use Modules\Auth\Actions\DeleteUser;
use Modules\Auth\Actions\FetchUser;
use Modules\Auth\Actions\FetchUsersDashboard;
use Modules\Auth\Actions\FetchUsersList;
use Modules\Auth\Actions\UpdateUser;
use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Resources\UserResource;
use Modules\Common\Core\DTOs\DashboardDTO;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;

final class UserController extends Controller
{
    public function index(DatatableDTO $dto, FetchUsersList $action): JsonResponse
    {
        return UserResource::collection($action->handle($dto))->response();
    }

    public function show(string $uuid, FetchUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid)));
    }

    public function store(CreateUserDTO $dto, CreateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new UserResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateUserDTO $dto, string $uuid, UpdateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid, $dto)));
    }

    public function destroy(string $uuid, DeleteUser $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }

    public function dashboard(DashboardDTO $dto, FetchUsersDashboard $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new JsonResource($action->handle($dto)));
    }
}
