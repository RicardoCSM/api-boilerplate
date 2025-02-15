<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Actions\FetchPermissionsList;
use Modules\Auth\Actions\FetchPermissionsModulesList;
use Modules\Auth\Resources\PermissionModuleResource;
use Modules\Auth\Resources\PermissionResource;
use Modules\Common\Core\DTOs\DatatableDTO;

final class PermissionController extends Controller
{
    public function index(DatatableDTO $dto, FetchPermissionsList $action): JsonResponse
    {
        return PermissionResource::collection($action->handle($dto))->response();
    }

    public function modules(FetchPermissionsModulesList $action): JsonResponse
    {
        return PermissionModuleResource::make($action->handle())->response();
    }
}
