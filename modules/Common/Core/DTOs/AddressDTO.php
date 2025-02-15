<?php

declare(strict_types=1);

namespace Modules\Common\Core\DTOs;

use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class AddressDTO extends ValidatedDTO
{
    public string $street;

    public ?string $number;

    public string $neighborhood;

    public string $city;

    public string $state;

    public string $postal_code;

    protected function rules(): array
    {
        return [
            'street' => ['required', 'string'],
            'number' => ['sometimes', 'nullable', 'string'],
            'neighborhood' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'number' => 'S/N',
        ];
    }

    protected function casts(): array
    {
        return [
            'street' => new StringCast(),
            'number' => new StringCast(),
            'neighborhood' => new StringCast(),
            'city' => new StringCast(),
            'state' => new StringCast(),
            'postal_code' => new StringCast(),
        ];
    }
}
