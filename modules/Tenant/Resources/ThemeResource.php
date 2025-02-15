<?php

declare(strict_types=1);

namespace Modules\Tenant\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\Common\Core\Resources\Concerns\HasMedia;
use Modules\Common\Core\Resources\MediaResource;

final class ThemeResource extends JsonResource
{
    use HasMedia;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'primary_logo_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'primary-logos', 'medium') ?: null,
            'contrast_primary_logo_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'contrast-primary-logos', 'medium') ?: null,
            'reduced_logo_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'reduced-logos', 'medium') ?: null,
            'contrast_reduced_logo_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'contrast-reduced-logos', 'medium') ?: null,
            'favicon_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'favicons', '192x192') ?: null,
            $this->mergeWhen($this->shouldIncludeMedia(), [
                'media' => MediaResource::collection($this->getMedia('*')),
            ]),
            'institutional_website_url' => $this->institutional_website_url,
            'primary_color_light' => $this->primary_color_light,
            'secondary_color_light' => $this->secondary_color_light,
            'primary_color_dark' => $this->primary_color_dark,
            'secondary_color_dark' => $this->secondary_color_dark,
            'app_store_url' => $this->app_store_url,
            'google_play_url' => $this->google_play_url,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
