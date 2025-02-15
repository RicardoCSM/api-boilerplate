<?php

declare(strict_types=1);

namespace Modules\Questionnaires\DTOs;

use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuestionnaireVersionDTO extends ValidatedDTO
{
    public ?int $version;

    protected function rules(): array
    {
        return [
            'version' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'version' => new IntegerCast(),
        ];
    }
}
