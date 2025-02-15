<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Modules\Tenant\Models\Ads;

final readonly class FetchAds
{
    public function handle(string $uuid): Ads
    {
        return Ads::getByOrFail('uuid', $uuid);
    }
}
