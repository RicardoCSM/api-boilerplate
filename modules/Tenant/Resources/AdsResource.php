<?php

declare(strict_types=1);

namespace Modules\Tenant\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\Common\Core\Resources\Concerns\HasMedia;
use Modules\Common\Core\Resources\MediaResource;

final class AdsResource extends JsonResource
{
    use HasMedia;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'background_image_url' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'background-images', 'optimized') ?: null,
            $this->mergeWhen($this->shouldIncludeMedia(), [
                'media' => MediaResource::collection($this->getMedia('*')),
            ]),
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'order' => $this->order,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
