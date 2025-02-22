<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CnhResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nome' => $this->resource['nome'] ?? null,
            'doc_identidade' => $this->resource['doc_identidade'] ?? null,
            'org-emissor' => $this->resource['org-emissor'] ?? null,
            'uf' => $this->resource['uf'] ?? null,
            'validade' => $this->resource['validade'] ?? null,
            'cpf' => $this->resource['cpf'] ?? null,
            'categoria_habilitacao' => $this->resource['categoria_habilitacao'] ?? null,
            'data_emissao' => $this->resource['data_emissao'] ?? null,
            'nome_mae' => $this->resource['nome_mae'] ?? null,
            'nome_pai' => $this->resource['nome_pai'] ?? null,
            'data_nascimento' => $this->resource['data_nascimento'] ?? null,
            'observacoes' => $this->resource['observacoes'] ?? null,
            'local' => $this->resource['local'] ?? null,
            'num_registro' => $this->resource['num_registro'] ?? null,
        ];
    }
}
