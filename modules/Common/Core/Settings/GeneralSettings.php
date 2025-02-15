<?php

declare(strict_types=1);

namespace Modules\Common\Core\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public static function group(): string
    {
        return 'general';
    }
}
