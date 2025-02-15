<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Modules\Tenant\Models\Ads;
use Modules\Tenant\Models\Theme;

final readonly class Bootstrap
{
    public function handle(): array
    {
        $bootstrap = [
            'tenant' => tenant(),
            'theme' => Theme::active(),
            'ads' => Ads::active()->ordered()->get(),
        ];

        return $bootstrap;
    }
}
