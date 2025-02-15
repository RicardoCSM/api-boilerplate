<?php

declare(strict_types=1);

namespace Modules\Questionnaires\DTOs;

use Modules\Common\Core\DTOs\Concerns\Utils;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UpdateQuestionnairesGroupDTO extends ValidatedDTO
{
    use Utils;

    public ?string $title;

    public ?string $description;

    public ?string $icon;

    public ?bool $active;

    protected function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'icon' => ['sometimes', 'nullable', 'string'],
            'active' => ['sometimes', 'boolean'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'title' => new StringCast(),
            'description' => new StringCast(),
            'icon' => new StringCast(),
            'active' => new BooleanCast(),
        ];
    }
}
