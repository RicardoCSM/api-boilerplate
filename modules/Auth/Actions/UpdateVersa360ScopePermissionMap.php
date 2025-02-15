<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\UpdateVersa360ScopePermissionMapDTO;
use Modules\Auth\Models\Versa360ScopePermissionMap;

final readonly class UpdateVersa360ScopePermissionMap
{
    public function __construct(private FetchVersa360ScopePermissionMap $fetchVersa360ScopePermissionMap) {}

    public function handle(string $scope_id, UpdateVersa360ScopePermissionMapDTO $dto): Versa360ScopePermissionMap
    {
        $versa360ScopePermissionMap = $this->fetchVersa360ScopePermissionMap->handle($scope_id);

        $versa360ScopePermissionMap->fill($dto->toArray());
        $versa360ScopePermissionMap->save();

        return $versa360ScopePermissionMap;
    }
}
