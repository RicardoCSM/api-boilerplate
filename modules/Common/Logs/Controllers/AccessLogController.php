<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Common\Core\DTOs\DateRangeDTO;
use Modules\Common\Logs\Actions\FetchAccessLogsList;
use Modules\Common\Logs\Resources\AccessLogResource;

class AccessLogController extends Controller
{
    public function index(Request $request, FetchAccessLogsList $action): JsonResponse
    {
        return AccessLogResource::collection($action->handle(DateRangeDTO::fromRequest($request)))->response();
    }
}
