<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    public function isActive(): bool
    {
        return $this->active;
    }

    public function isInactive(): bool
    {
        return ! $this->active;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('active', false);
    }
}
