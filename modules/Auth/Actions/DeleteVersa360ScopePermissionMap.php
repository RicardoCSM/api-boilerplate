<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

final readonly class DeleteVersa360ScopePermissionMap
{
    public function __construct(private FetchVersa360ScopePermissionMap $fetchVersa360ScopePermissionMap) {}

    public function handle(string $uuid): void
    {
        $versa360ScopePermissionMap = $this->fetchVersa360ScopePermissionMap->handle($uuid);
        $versa360ScopePermissionMap->delete();
    }
}
