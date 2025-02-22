<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource['type'] ?? null,
        ];
    }
}
