<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Filters;

use Modules\Common\Core\Filters\Abstracts\Filters;
use Modules\Common\Core\Filters\WhereDateEqualFilter;
use Modules\Common\Core\Filters\WhereDateGreaterFilter;
use Modules\Common\Core\Filters\WhereDateLessFilter;
use Modules\Common\Core\Filters\WhereFilter;

final class QuestionnaireResponsesFilters extends Filters
{
    protected array $filters = [
        'questionnaire_id' => WhereQuestionnaireIdFilter::class,
        'version' => WhereFilter::class,
        'begin' => WhereDateGreaterFilter::class,
        'end' => WhereDateLessFilter::class,
        'created_at' => WhereDateEqualFilter::class,
    ];
}
