<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Support\ImpersonateManager;

final readonly class TakeUser
{
    private const TOKEN_TYPE = 'Bearer';

    public function __construct(
        private FetchUser $fetchUser,
        private ImpersonateManager $impersonate,
    ) {}

    public function handle(string $uuid): array
    {
        $impersonator = Auth::user();
        $impersonated = $this->fetchUser->handle($uuid);

        $token = $this->impersonate->take($impersonator, $impersonated);
        if (! $token) {
            throw new AuthenticationException();
        }

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ];
    }
}
