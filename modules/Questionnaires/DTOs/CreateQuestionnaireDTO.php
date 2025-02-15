<?php

declare(strict_types=1);

namespace Modules\Questionnaires\DTOs;

use Illuminate\Validation\Rule;
use Modules\Questionnaires\Models\QuestionnairesGroup;
use WendellAdriel\ValidatedDTO\Casting\ArrayCast;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CreateQuestionnaireDTO extends ValidatedDTO
{
    public int $questionnaires_group_id;

    public string $title;

    public ?string $description;

    public ?string $icon;

    public bool $active;

    protected function rules(): array
    {
        return [
            'questionnaires_group_id' => ['required', 'string', Rule::exists('questionnaires_groups', 'uuid')],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'icon' => ['sometimes', 'nullable', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'elements' => [],
            'active' => false,
        ];
    }

    protected function casts(): array
    {
        return [
            'questionnaires_group_id' => fn (string $property, mixed $value) => QuestionnairesGroup::findByUuid($value)->id,
            'title' => new StringCast(),
            'description' => new StringCast(),
            'icon' => new StringCast(),
            'elements' => new ArrayCast(),
            'active' => new BooleanCast(),
        ];
    }
}
