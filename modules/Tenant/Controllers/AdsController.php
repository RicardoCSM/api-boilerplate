<?php

declare(strict_types=1);

namespace Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\DTOs\ReorderDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;
use Modules\Tenant\Actions\CreateAds;
use Modules\Tenant\Actions\DeleteAds;
use Modules\Tenant\Actions\FetchAds;
use Modules\Tenant\Actions\FetchAdsList;
use Modules\Tenant\Actions\ReorderAds;
use Modules\Tenant\Actions\UpdateAds;
use Modules\Tenant\DTOs\CreateAdsDTO;
use Modules\Tenant\DTOs\UpdateAdsDTO;
use Modules\Tenant\Resources\AdsResource;

final class AdsController extends Controller
{
    public function index(DatatableDTO $dto, FetchAdsList $action): JsonResponse
    {
        return AdsResource::collection($action->handle($dto))->response();
    }

    public function show(string $uuid, FetchAds $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new AdsResource($action->handle($uuid)));
    }

    public function store(CreateAdsDTO $dto, CreateAds $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new AdsResource($action->handle($dto)),
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateAdsDTO $dto, string $uuid, UpdateAds $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new AdsResource($action->handle($uuid, $dto)));
    }

    public function destroy(string $uuid, DeleteAds $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }

    public function reorder(ReorderDTO $dto, ReorderAds $action): NoContentResponse
    {
        $action->handle($dto);

        return new NoContentResponse();
    }
}
