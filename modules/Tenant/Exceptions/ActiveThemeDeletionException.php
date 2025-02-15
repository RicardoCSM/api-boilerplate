<?php

declare(strict_types=1);

namespace Modules\Tenant\Exceptions;

use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

final class ActiveThemeDeletionException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Não é possível excluir um tema ativo.',
            Response::HTTP_BAD_REQUEST,
        );
    }
}
