<?php

declare(strict_types=1);

namespace Modules\Tenant\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class BootstrapResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tenant' => [
                'name' => $this->resource['tenant']['name'],
                'modules' => $this->resource['tenant']['modules'],
                'theme' => new ThemeResource($this->resource['theme']),
                'ads' => AdsResource::collection($this->resource['ads']),
            ],
        ];
    }
}
