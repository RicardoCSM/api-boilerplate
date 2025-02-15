<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rule;
use Modules\Common\Core\DTOs\UploadedFileDTO;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ChangeUserAvatarDTO extends ValidatedDTO
{
    public UploadedFileDTO $file;

    protected function rules(): array
    {
        return [
            'file' => ['required', 'array'],
            'file.extension' => ['required', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'file' => new DTOCast(UploadedFileDTO::class),
        ];
    }
}
