<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Common\Core\Models\Model;

final class QuestionnaireResponse extends Model
{
    protected $fillable = [
        'uuid',
        'questionnaire_id',
        'version',
        'answers',
        'started_at',
        'ended_at',
    ];

    protected $nullable = [
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'version' => 'integer',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function scopeAll(Builder $query): Builder
    {
        return $query;
    }
}
