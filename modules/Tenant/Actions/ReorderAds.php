<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Modules\Common\Core\DTOs\ReorderDTO;
use Modules\Tenant\Models\Ads;

final readonly class ReorderAds
{
    public function handle(ReorderDTO $dto): void
    {
        Ads::setNewOrderByCustomColumn('uuid', $dto->ids, $dto->starting);
    }
}
