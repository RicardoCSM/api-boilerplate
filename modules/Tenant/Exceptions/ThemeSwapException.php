<?php

declare(strict_types=1);

namespace Modules\Tenant\Exceptions;

use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

final class ThemeSwapException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Para inativar um tema é necessário escolher um novo para ser ativado.',
            Response::HTTP_BAD_REQUEST,
        );
    }
}
