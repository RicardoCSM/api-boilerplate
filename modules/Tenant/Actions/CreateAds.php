<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\DTOs\CreateAdsDTO;
use Modules\Tenant\Models\Ads;

final readonly class CreateAds
{
    public function handle(CreateAdsDTO $dto): Ads
    {
        try {
            DB::beginTransaction();

            $ads = $dto->toModel(Ads::class);
            $ads->save();

            if (isset($dto->background_image)) {
                $ads->addMediaFromDisk($dto->background_image->key, 'central')
                    ->usingFileName($dto->background_image->uuid . '.' . $dto->background_image->extension)
                    ->toMediaCollection('background-images');
            }

            $dto->active ? $ads->moveToStart() : $ads->moveToEnd();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $ads;
    }
}
