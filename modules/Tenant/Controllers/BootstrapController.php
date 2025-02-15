<?php

declare(strict_types=1);

namespace Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Tenant\Actions\Bootstrap;
use Modules\Tenant\Resources\BootstrapResource;

final class BootstrapController extends Controller
{
    public function __invoke(Bootstrap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new BootstrapResource($action->handle()));
    }
}
