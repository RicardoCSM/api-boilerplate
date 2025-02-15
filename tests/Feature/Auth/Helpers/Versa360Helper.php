<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Helpers;

use Modules\Auth\Models\Versa360ScopePermissionMap;
use Modules\Auth\Support\Permissions;

class Versa360Helper
{
    public static function createTestVersa360ScopePermissionMap(): Versa360ScopePermissionMap
    {
        $versa360ScopePermissionMap = new Versa360ScopePermissionMap([
            'scope_id' => fake()->uuid(),
            'permissions' => [Permissions::LIST_USERS->value],
        ]);

        $versa360ScopePermissionMap->save();

        return $versa360ScopePermissionMap;
    }

    public static function dumbVersa360ScopePermissionMapData(): array
    {
        return [
            'scope_id' => 'dumb-scope-id',
            'permissions' => [Permissions::LIST_USERS->value],
        ];
    }
}
