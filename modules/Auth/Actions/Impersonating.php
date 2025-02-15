<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Exceptions\ImpersonationException;
use Modules\Auth\Support\ImpersonateManager;

final readonly class Impersonating
{
    private const TOKEN_TYPE = 'Bearer';

    public function __construct(
        private FetchUser $fetchUser,
        private ImpersonateManager $impersonate,
    ) {}

    public function handle(): array
    {
        if (! $this->impersonate->isImpersonating()) {
            throw new ImpersonationException('Você não está impersonando um usuário.');
        }

        return [
            'type' => self::TOKEN_TYPE,
            'token' => request()->bearerToken(),
            'is_impersonating' => $this->impersonate->isImpersonating(),
            'impersonator' => $this->fetchUser->handle($this->impersonate->getImpersonatorId()),
            'impersonated' => Auth::user(),
        ];
    }
}
