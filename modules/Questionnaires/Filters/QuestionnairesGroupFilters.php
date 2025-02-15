<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Filters;

use Modules\Common\Core\Filters\Abstracts\Filters;
use Modules\Common\Core\Filters\ActiveFilter;
use Modules\Common\Core\Filters\WhereDateEqualFilter;
use Modules\Common\Core\Filters\WhereDateGreaterFilter;
use Modules\Common\Core\Filters\WhereDateLessFilter;
use Modules\Common\Core\Filters\WhereLikeFilter;

final class QuestionnairesGroupFilters extends Filters
{
    protected array $filters = [
        'title' => WhereLikeFilter::class,
        'active' => ActiveFilter::class,
        'begin' => WhereDateGreaterFilter::class,
        'end' => WhereDateLessFilter::class,
        'created_at' => WhereDateEqualFilter::class,
    ];
}
