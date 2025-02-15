<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\DTOs\UpdateAdsDTO;
use Modules\Tenant\Models\Ads;

final readonly class UpdateAds
{
    public function __construct(private FetchAds $fetchAds) {}

    public function handle(string $uuid, UpdateAdsDTO $dto): Ads
    {
        $ads = $this->fetchAds->handle($uuid);

        $updateData = $dto->nullableSafeToArray(Ads::nullable());

        try {
            DB::beginTransaction();

            if ($dto->background_image) {
                $ads->addMediaFromDisk($dto->background_image->key, 'central')
                    ->usingFileName($dto->background_image->uuid . '.' . $dto->background_image->extension)
                    ->toMediaCollection('background-images');
            }

            if ($dto->active === true && ! $ads->active) {
                $ads->moveToStart();
            }

            if ($dto->active === false && $ads->active) {
                $ads->moveToEnd();
            }

            $ads->fill($updateData);
            $ads->push();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $ads;
    }
}
