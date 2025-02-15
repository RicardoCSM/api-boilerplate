<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Exception;
use Modules\Auth\Support\DefaultRoles;
use Modules\Common\Core\DTOs\DatatableDTO;

final readonly class DeleteRole
{
    public function __construct(private FetchRole $fetchRole, private FetchRoleMember $fetchRoleMember) {}

    public function handle(string $role): void
    {
        $role = $this->fetchRole->handle($role);

        throw_if($role->name === DefaultRoles::ADMIN->value, new Exception('Não é permitido deletar o grupo ' . $role->descripiton . '.'));

        $dto = new DatatableDTO();
        $dto->per_page = 'all';
        $members = $this->fetchRoleMember->handle($role->name, $dto);

        if ($members->count() > 0) {
            throw new Exception('Grupo não pode ser excluído por estar em uso.');
        }

        $role->delete();
    }
}
