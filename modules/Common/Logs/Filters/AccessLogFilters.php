<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Filters;

use Modules\Common\Core\Filters\Abstracts\Filters;
use Modules\Common\Core\Filters\WhereLikeFilter;

final class AccessLogFilters extends Filters
{
    protected array $filters = [
        'module' => WhereLikeFilter::class,
        'action' => WhereLikeFilter::class,
    ];
}
