<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Actions\FetchRolePermissionsList;
use Modules\Auth\Actions\SyncRolePermissions;
use Modules\Auth\DTOs\SyncRolePermissionsDTO;
use Modules\Auth\Resources\PermissionResource;
use Modules\Common\Core\Responses\NoContentResponse;

final class RolePermissionController extends Controller
{
    public function index(string $role, FetchRolePermissionsList $action): JsonResponse
    {
        return PermissionResource::collection($action->handle($role))->response();
    }

    public function store(SyncRolePermissionsDTO $dto, string $role, SyncRolePermissions $action): NoContentResponse
    {
        $action->handle($role, $dto);

        return new NoContentResponse();
    }
}
