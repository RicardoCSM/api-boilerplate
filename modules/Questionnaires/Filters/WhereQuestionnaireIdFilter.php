<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filter;

class WhereQuestionnaireIdFilter extends Filter
{
    public function apply(Builder $builder, mixed $value, string $filter): Builder
    {
        return $builder->whereHas('questionnaire', function ($query) use ($value) {
            $query->where('uuid', $value);
        });
    }
}
