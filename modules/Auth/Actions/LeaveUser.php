<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Modules\Auth\Support\ImpersonateManager;

final readonly class LeaveUser
{
    private const TOKEN_TYPE = 'Bearer';

    public function __construct(private ImpersonateManager $impersonate) {}

    public function handle(): array
    {
        $token = $this->impersonate->leave();
        if (! $token) {
            throw new AuthenticationException();
        }

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ];
    }
}
