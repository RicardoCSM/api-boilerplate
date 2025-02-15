<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filters;

trait Filterable
{
    public function scopeFiltered(Builder $query, Filters $filters): Builder
    {
        return $filters->apply($query);
    }
}
