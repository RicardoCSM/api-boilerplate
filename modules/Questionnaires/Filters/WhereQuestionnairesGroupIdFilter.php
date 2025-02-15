<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filter;

class WhereQuestionnairesGroupIdFilter extends Filter
{
    public function apply(Builder $builder, mixed $value, string $filter): Builder
    {
        return $builder->whereHas('questionnairesGroup', function ($query) use ($value) {
            $query->where('uuid', $value);
        });
    }
}
