<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Password;
use Modules\Auth\Models\Role;
use WendellAdriel\ValidatedDTO\Casting\ArrayCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class CreateUserDTO extends ValidatedDTO
{
    public string $name;

    public string $login;

    public string $email;

    public string $password;

    public Role $role;

    public array $extra_permissions;

    public array $units;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'login' => ['required', 'string', 'min:4', 'max:20', 'alpha_dash', 'unique:users,login'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => [
                'required',
                Password::min(8)->max(255),
                'confirmed',
            ],
            'role' => ['sometimes', 'string', 'exists:roles,name', 'not_in:super-admin'],
            'extra_permissions' => ['sometimes', 'array'],
            'extra_permissions.*' => ['exists:permissions,name'],
            'units' => ['sometimes', 'array'],
            'units.*' => ['string', 'exists:units,uuid'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'role' => 'user',
            'extra_permissions' => [],
            'units' => [],
        ];
    }

    protected function casts(): array
    {
        return [
            'role' => fn (string $property, mixed $value) => Role::findByName($value),
            'units' => new ArrayCast(new StringCast()),
        ];
    }
}
