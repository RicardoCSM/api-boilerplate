<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use WendellAdriel\ValidatedDTO\Casting\ArrayCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class UpdateVersa360ScopePermissionMapDTO extends ValidatedDTO
{
    public ?array $permissions;

    protected function rules(): array
    {
        return [
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
            'permissions' => new ArrayCast(new StringCast()),
        ];
    }
}
