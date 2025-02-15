<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\Common\Core\Models\Media;
use Modules\Common\Core\Models\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Theme extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'institutional_website_url',
        'primary_color_light',
        'secondary_color_light',
        'primary_color_dark',
        'secondary_color_dark',
        'app_store_url',
        'google_play_url',
        'active',
    ];

    protected $nullable = [
        'app_store_url',
        'google_play_url',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public static function active(): ?Theme
    {
        return Cache::remember(
            'theme:active',
            Carbon::now()->addHours(2),
            fn () => static::where('active', true)->first()
        );
    }

    public static function enable(string $uuid): void
    {
        self::updateBy('uuid', $uuid, ['active' => true]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary-logos')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('small')->width(100)->height(100)->keepOriginalImageFormat();
                $this->addMediaConversion('medium')->width(400)->height(400)->keepOriginalImageFormat();
                $this->addMediaConversion('large')->width(800)->height(800)->keepOriginalImageFormat();
            });

        $this->addMediaCollection('contrast-primary-logos')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('small')->width(100)->height(100)->keepOriginalImageFormat();
                $this->addMediaConversion('medium')->width(400)->height(400)->keepOriginalImageFormat();
                $this->addMediaConversion('large')->width(800)->height(800)->keepOriginalImageFormat();
            });

        $this->addMediaCollection('favicons')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('16x16')->width(16)->height(16)->keepOriginalImageFormat();
                $this->addMediaConversion('32x32')->width(32)->height(32)->keepOriginalImageFormat();
                $this->addMediaConversion('96x96')->width(96)->height(96)->keepOriginalImageFormat();
                $this->addMediaConversion('192x192')->width(192)->height(192)->keepOriginalImageFormat();
                $this->addMediaConversion('512x512')->width(512)->height(512)->keepOriginalImageFormat();
            });

        $this->addMediaCollection('reduced-logos')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('small')->width(100)->height(100)->keepOriginalImageFormat();
                $this->addMediaConversion('medium')->width(400)->height(400)->keepOriginalImageFormat();
                $this->addMediaConversion('large')->width(800)->height(800)->keepOriginalImageFormat();
            });

        $this->addMediaCollection('contrast-reduced-logos')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('small')->width(100)->height(100)->keepOriginalImageFormat();
                $this->addMediaConversion('medium')->width(400)->height(400)->keepOriginalImageFormat();
                $this->addMediaConversion('large')->width(800)->height(800)->keepOriginalImageFormat();
            });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    protected static function booted(): void
    {
        static::saving(function (Theme $theme) {
            if ($theme->active) {
                static::where('active', true)
                    ->where('id', '!=', $theme->id)
                    ->update(['active' => false]);
                Cache::forget('theme:active');
            }
        });
    }
}
