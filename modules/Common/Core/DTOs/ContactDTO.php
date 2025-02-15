<?php

declare(strict_types=1);

namespace Modules\Common\Core\DTOs;

use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ContactDTO extends ValidatedDTO
{
    public string $type;

    public string $value;

    protected function rules(): array
    {
        return [
            'type' => ['required', 'string'],
            'value' => ['required', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'type' => new StringCast(),
            'value' => new StringCast(),
        ];
    }
}
