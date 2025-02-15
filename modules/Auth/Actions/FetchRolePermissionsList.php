<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Database\Eloquent\Collection;

final readonly class FetchRolePermissionsList
{
    public function __construct(private FetchRole $fetchRole) {}

    public function handle(string $role): Collection
    {
        $role = $this->fetchRole->handle($role);

        return $role->permissions;
    }
}
