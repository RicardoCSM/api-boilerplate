<?php

declare(strict_types=1);

namespace Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;
use Modules\Tenant\Actions\CreateTheme;
use Modules\Tenant\Actions\DeleteTheme;
use Modules\Tenant\Actions\FetchTheme;
use Modules\Tenant\Actions\FetchThemeList;
use Modules\Tenant\Actions\UpdateTheme;
use Modules\Tenant\DTOs\CreateThemeDTO;
use Modules\Tenant\DTOs\UpdateThemeDTO;
use Modules\Tenant\Resources\ThemeResource;

final class ThemeController extends Controller
{
    public function index(DatatableDTO $dto, FetchThemeList $action): JsonResponse
    {
        return ThemeResource::collection($action->handle($dto))->response();
    }

    public function show(string $uuid, FetchTheme $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new ThemeResource($action->handle($uuid)));
    }

    public function store(CreateThemeDTO $dto, CreateTheme $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new ThemeResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateThemeDTO $dto, string $uuid, UpdateTheme $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new ThemeResource($action->handle($uuid, $dto)));
    }

    public function destroy(string $uuid, DeleteTheme $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }
}
