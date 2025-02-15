<?php

declare(strict_types=1);

namespace Modules\Common\Core\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ReorderDTO extends ValidatedDTO
{
    public array $ids;

    public ?int $starting;

    protected function rules(): array
    {
        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'uuid'],
            'starting' => ['sometimes', 'nullable', 'integer'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'starting' => 1,
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
