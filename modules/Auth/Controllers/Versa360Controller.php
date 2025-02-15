<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Actions\CreateVersa360ScopePermissionMap;
use Modules\Auth\Actions\DeleteVersa360ScopePermissionMap;
use Modules\Auth\Actions\FetchVersa360Client;
use Modules\Auth\Actions\FetchVersa360ScopePermissionMap;
use Modules\Auth\Actions\UpdateVersa360ScopePermissionMap;
use Modules\Auth\Actions\Versa360Redirect;
use Modules\Auth\DTOs\CreateVersa360ScopePermissionMapDTO;
use Modules\Auth\DTOs\UpdateVersa360ScopePermissionMapDTO;
use Modules\Auth\Resources\Versa360ClientResource;
use Modules\Auth\Resources\Versa360RedirectResource;
use Modules\Auth\Resources\Versa360ScopePermissionMapResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;

final class Versa360Controller extends Controller
{
    public function show(string $scope_id, FetchVersa360ScopePermissionMap $action)
    {
        return new ApiSuccessResponse(new Versa360ScopePermissionMapResource($action->handle($scope_id)));
    }

    public function store(CreateVersa360ScopePermissionMapDTO $dto, CreateVersa360ScopePermissionMap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new Versa360ScopePermissionMapResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateVersa360ScopePermissionMapDTO $dto, string $scope_id, UpdateVersa360ScopePermissionMap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360ScopePermissionMapResource($action->handle($scope_id, $dto)));
    }

    public function destroy(string $scope_id, DeleteVersa360ScopePermissionMap $action): NoContentResponse
    {
        $action->handle($scope_id);

        return new NoContentResponse();
    }

    public function client(FetchVersa360Client $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360ClientResource($action->handle()));
    }

    public function redirect(Versa360Redirect $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360RedirectResource($action->handle()));
    }
}
