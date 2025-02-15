<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUuids as BaseHasUuids;

trait HasUuids
{
    use BaseHasUuids;

    public function getHidden(): array
    {
        return array_merge(parent::getHidden(), ['id']);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
