<?php

declare(strict_types=1);

namespace Modules\Tenant\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TenantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'domains' => $this->domains->pluck('domain'),
        ];
    }
}
