<?php

declare(strict_types=1);

namespace Modules\Auth\Filters;

use Modules\Common\Core\Filters\Abstracts\Filters;
use Modules\Common\Core\Filters\ActiveFilter;
use Modules\Common\Core\Filters\WhereDateEqualFilter;
use Modules\Common\Core\Filters\WhereDateGreaterFilter;
use Modules\Common\Core\Filters\WhereDateLessFilter;
use Modules\Common\Core\Filters\WhereLikeFilter;

final class UserFilters extends Filters
{
    protected array $filters = [
        'name' => WhereLikeFilter::class,
        'email' => WhereLikeFilter::class,
        'login' => WhereLikeFilter::class,
        'active' => ActiveFilter::class,
        'begin' => WhereDateGreaterFilter::class,
        'end' => WhereDateLessFilter::class,
        'created_at' => WhereDateEqualFilter::class,
        'roles' => RolesFilter::class,
    ];
}
