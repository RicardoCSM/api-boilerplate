<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasTimestampsHistory
{
    protected static bool $isDeleting = false;

    protected static function bootHasTimestampsHistory()
    {
        static::creating(function (Model $model) {
            if (! $model->started_at) {
                $model->started_at = now();
            }
        });

        static::updating(function (Model $model) {
            if (self::$isDeleting) {
                return;
            }

            $history = $model->replicate();
            $history->uuid = $model->uuid;
            $history->expired_at = now();

            foreach ($model->getDirty() as $attribute => $value) {
                $history->{$attribute} = $model->getOriginal($attribute);
            }

            $history->save();

            $model->uuid = Str::uuid();
            $model->started_at = now();
        });

        static::deleting(function (Model $model) {
            self::$isDeleting = true;
            $model->expired_at = now();
        });

        static::deleted(function (Model $model) {
            self::$isDeleting = false;
        });
    }
}
