<?php

declare(strict_types=1);

namespace Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Tenant\Actions\CreateTenant;
use Modules\Tenant\DTOs\CreateTenantDTO;
use Modules\Tenant\Resources\TenantResource;

final class TenantController extends Controller
{
    public function store(Request $request, CreateTenant $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new TenantResource($action->handle(CreateTenantDTO::fromRequest($request))),
            Response::HTTP_CREATED
        );
    }
}
