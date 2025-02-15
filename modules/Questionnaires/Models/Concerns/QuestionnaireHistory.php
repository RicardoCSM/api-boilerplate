<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait QuestionnaireHistory
{
    protected static bool $isDeleting = false;

    protected static function bootQuestionnaireHistory()
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

            if ($model->version === $model->getOriginal('version')) {
                return;
            }

            $history = $model->replicate();
            $history->uuid = $model->uuid;
            $history->expired_at = now();

            foreach ($model->getDirty() as $attribute => $value) {
                $history->{$attribute} = $model->getOriginal($attribute);
            }

            $history->save();

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
