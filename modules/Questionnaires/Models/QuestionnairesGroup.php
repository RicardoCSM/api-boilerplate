<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Common\Core\Models\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

final class QuestionnairesGroup extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'icon',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $nullable = [
        'description',
        'icon',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }
}
