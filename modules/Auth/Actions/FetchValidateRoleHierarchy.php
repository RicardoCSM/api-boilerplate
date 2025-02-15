<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Support\DefaultRoles;

final readonly class FetchValidateRoleHierarchy
{
    public function __construct(
        private FetchRole $fetchRole,
    ) {}

    public function handle(array|string $roles): bool
    {
        $rolesUser = Auth::user()->roles;

        if ($rolesUser->contains('name', DefaultRoles::ADMIN->value) || $rolesUser->whereIn('name', $roles)->isNotEmpty()) {
            return true;
        }

        return false;
    }
}
