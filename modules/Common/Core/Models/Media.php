<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected static function booted(): void
    {
        static::addGlobalScope(
            'not_trash',
            fn (Builder $builder) => $builder->where('collection_name', '!=', 'trash')
        );
    }
}
