<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\Versa360ScopePermissionMap;

final readonly class FetchVersa360ScopePermissionMap
{
    public function handle(string $scope_id): Versa360ScopePermissionMap
    {
        return Versa360ScopePermissionMap::where('scope_id', $scope_id)->firstOrFail();
    }
}
