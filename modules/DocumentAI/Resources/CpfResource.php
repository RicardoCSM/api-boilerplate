<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CpfResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'cpf' => $this->resource['cpf'] ?? null,
        ];
    }
}
