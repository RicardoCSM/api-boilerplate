<?php

declare(strict_types=1);

namespace Modules\Common\Core\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UploadedFileDTO extends ValidatedDTO
{
    public string $uuid;

    public string $bucket;

    public string $key;

    public string $extension;

    protected function rules(): array
    {
        return [
            'uuid' => ['required', 'string', 'uuid'],
            'bucket' => ['required', 'string'],
            'key' => ['required', 'string'],
            'extension' => ['required', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
