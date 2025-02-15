<?php

declare(strict_types=1);

namespace Modules\Common\Core\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'collection' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'url' => $this->resource->getTemporaryUrl(Carbon::now()->addHours(2)),
            'conversions' => $this->resource->getGeneratedConversions()->keys(),
            'custom_properties' => $this->custom_properties,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
