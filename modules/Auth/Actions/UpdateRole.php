<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Exception;
use Modules\Auth\DTOs\UpdateRoleDTO;
use Modules\Auth\Models\Role;
use Modules\Auth\Support\DefaultRoles;

final readonly class UpdateRole
{
    public function __construct(private FetchRole $fetchRole) {}

    public function handle(string $role, UpdateRoleDTO $dto): Role
    {
        $role = $this->fetchRole->handle($role);

        if (isset($dto->name)) {
            throw_if($role->name === DefaultRoles::ADMIN->value, new Exception('Não é permitido alterar o nome do grupo ' . $role->descripiton . '.'));
        }

        $role->fill($dto->toArray());
        $role->save();

        return $role;
    }
}
