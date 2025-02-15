<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Exception;
use Modules\Auth\DTOs\SyncRolePermissionsDTO;

final readonly class SyncRolePermissions
{
    public function __construct(private FetchRole $fetchRole, private FetchValidateRoleHierarchy $fetchValidateRoleHierarchy) {}

    public function handle(string $role, SyncRolePermissionsDTO $dto): void
    {
        throw_if(! $this->fetchValidateRoleHierarchy->handle($role), new Exception('Selecione apenas grupos que você tem acesso.'));

        $role = $this->fetchRole->handle($role);
        $role->syncPermissions($dto->permissions);
    }
}
