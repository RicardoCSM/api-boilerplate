<?php

declare(strict_types=1);

namespace Modules\Questionnaires\DTOs;

use Modules\Questionnaires\Models\QuestionnairesGroup;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CreateQuestionnairesGroupDTO extends ValidatedDTO
{
    public string $title;

    public ?string $description;

    public ?string $icon;

    public bool $active;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string'],
            'active' => ['sometimes', 'boolean'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'order' => QuestionnairesGroup::max('order') + 1,
            'active' => true,
        ];
    }

    protected function casts(): array
    {
        return [
            'title' => new StringCast(),
            'description' => new StringCast(),
            'icon' => new StringCast(),
            'order' => new IntegerCast(),
            'active' => new BooleanCast(),
        ];
    }
}
