<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\ChangeUserAvatar;
use Modules\Auth\DTOs\ChangeUserAvatarDTO;
use Modules\Auth\Resources\UserResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

class ChangeUserAvatarController extends Controller
{
    public function __invoke(ChangeUserAvatarDTO $dto, string $uuid, ChangeUserAvatar $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid, $dto)));
    }
}
