<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Models\Media;
use Modules\Common\Core\Models\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ads extends Model implements HasMedia, Sortable
{
    use InteractsWithMedia,
        SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'title',
        'description',
        'background_image_url',
        'button_text',
        'button_url',
        'start_date',
        'end_date',
        'order',
        'active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
    ];

    protected $nullable = [
        'description',
        'button_text',
        'button_url',
        'start_date',
        'end_date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background-images')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('optimized');
            });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true)
            ->where(function (Builder $query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now()->endOfDay());
            })
            ->where(function (Builder $query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now()->startOfDay());
            });
    }
}
