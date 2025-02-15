<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\CreateVersa360ScopePermissionMapDTO;
use Modules\Auth\Models\Versa360ScopePermissionMap;

final readonly class CreateVersa360ScopePermissionMap
{
    public function handle(CreateVersa360ScopePermissionMapDTO $dto): Versa360ScopePermissionMap
    {
        $versa360ScopePermissionMap = $dto->toModel(Versa360ScopePermissionMap::class);
        $versa360ScopePermissionMap->save();

        return $versa360ScopePermissionMap;
    }
}
