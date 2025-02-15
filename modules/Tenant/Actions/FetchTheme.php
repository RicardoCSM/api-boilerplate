<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Modules\Tenant\Models\Theme;

final readonly class FetchTheme
{
    public function handle(string $uuid): Theme
    {
        return Theme::getByOrFail('uuid', $uuid);
    }
}
