<?php

declare(strict_types=1);

namespace Modules\Common\Core\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Core\Actions\DeleteMedia;
use Modules\Common\Core\Responses\NoContentResponse;

final class DeleteMediaController extends Controller
{
    public function __invoke(string $uuid, DeleteMedia $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }
}
