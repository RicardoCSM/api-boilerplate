<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Exception;
use Illuminate\Support\Facades\DB;

final readonly class DeleteAds
{
    public function __construct(private FetchAds $fetchAds) {}

    public function handle(string $uuid): void
    {
        $ads = $this->fetchAds->handle($uuid);

        try {
            DB::beginTransaction();

            $ads->media->each->move($ads, 'trash');

            $ads->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
