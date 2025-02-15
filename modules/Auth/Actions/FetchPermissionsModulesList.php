<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\Permission;
use Modules\Auth\Support\PermissionGroups;

final readonly class FetchPermissionsModulesList
{
    public function handle(): array
    {
        $permissions = Permission::query()->get();

        return [
            'modules' => $this->getModules($permissions),
        ];
    }

    private function getModules(Collection $permissions): array
    {
        $modules = PermissionGroups::modules();

        foreach ($modules as $key => $module) {
            $groups = $module['groups'];
            foreach ($groups as $groupKey => $group) {
                $complete_key = $module['name'] . ':' . $group;
                $filteredPermissions = $permissions->filter(fn ($permission) => PermissionGroups::fromPermission($permission->name)->value === $complete_key);

                $modules[$key]['groups'][$groupKey] = [
                    'name' => $group,
                    'permissions' => $filteredPermissions->map(fn ($permission) => [
                        'name' => $permission->name,
                        'description' => $permission->description,
                    ])->toArray(),
                ];
            }
        }

        return $modules;

    }
}
