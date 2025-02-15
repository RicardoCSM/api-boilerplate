<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use WendellAdriel\ValidatedDTO\Casting\ArrayCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class CreateVersa360ScopePermissionMapDTO extends ValidatedDTO
{
    public string $scope_id;

    public array $permissions;

    protected function rules(): array
    {
        return [
            'scope_id' => ['required', 'string', 'unique:versa360_scopes_permissions_map,scope_id'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['required', 'string', 'exists:permissions,name'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'permissions' => [],
        ];
    }

    protected function casts(): array
    {
        return [
            'scope_id' => new StringCast(),
            'permissions' => new ArrayCast(new StringCast()),
        ];
    }
}
