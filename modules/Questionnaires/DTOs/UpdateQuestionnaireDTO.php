<?php

declare(strict_types=1);

namespace Modules\Questionnaires\DTOs;

use Modules\Common\Core\DTOs\Concerns\Utils;
use WendellAdriel\ValidatedDTO\Casting\ArrayCast;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UpdateQuestionnaireDTO extends ValidatedDTO
{
    use Utils;

    public ?string $title;

    public ?string $description;

    public ?string $icon;

    public ?array $elements;

    public ?bool $active;

    protected function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'icon' => ['sometimes', 'nullable', 'string'],
            'elements' => ['sometimes', 'array'],
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
            'elements' => new ArrayCast(new DTOCast(QuestionnaireElementDTO::class)),
            'active' => new BooleanCast(),
        ];
    }
}
