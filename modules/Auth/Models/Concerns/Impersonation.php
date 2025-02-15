<?php

declare(strict_types=1);

namespace Modules\Auth\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Support\Facades\Impersonate;

trait Impersonation
{
    public function canImpersonate(): bool
    {
        return $this->hasPermissionTo('ALL-impersonate');
    }

    public function canBeImpersonated(): bool
    {
        return $this->hasPermissionTo('ALL-be-impersonated');
    }

    public function impersonate(Model $user): string
    {
        return Impersonate::take($this, $user);
    }

    public function isImpersonated(): bool
    {
        return Impersonate::isImpersonating();
    }

    public function leaveImpersonation(): string
    {
        return Impersonate::leave();
    }
}
