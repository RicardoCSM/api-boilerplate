<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this->resource['nome'] ?? null,
            'nome_mae' => $this->resource['nome_mae'] ?? null,
            'nome_pai' => $this->resource['nome_pai'] ?? null,
            'cpf' => $this->resource['cpf'] ?? null,
            'rg' => $this->resource['rg'] ?? null,
            'data_expedicao' => $this->resource['data_expedicao'] ?? null,
            'data_nascimento' => $this->resource['data_nascimento'] ?? null,
            'naturalidade' => $this->resource['naturalidade'] ?? null,
        ];
    }
}
