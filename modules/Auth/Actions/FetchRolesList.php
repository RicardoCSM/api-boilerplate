<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\Role;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Support\Datatable;
use Modules\Common\Core\Support\Modules;
use Modules\Common\Logs\Support\AccessActions;
use Modules\Common\Logs\Support\AccessLogHelper;

final readonly class FetchRolesList
{
    public function handle(DatatableDTO $dto): LengthAwarePaginator|Collection
    {
        $query = Role::query();
        $query = Datatable::applyFilter($query, $dto, ['name', 'description']);
        $query = Datatable::applySort($query, $dto);

        if ($dto->log) {
            AccessLogHelper::log(
                action: AccessActions::DATATABLE_VIEW,
                module: Modules::ROLES,
                customMessage: AccessActions::DATATABLE_VIEW->message() . Modules::ROLES->description()
            );
        }

        return Datatable::applyPagination($query, $dto);
    }
}
