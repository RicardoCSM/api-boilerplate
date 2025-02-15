<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\DTOs\CreateThemeDTO;
use Modules\Tenant\Models\Theme;

final readonly class CreateTheme
{
    public function handle(CreateThemeDTO $dto): Theme
    {
        try {
            DB::beginTransaction();

            $theme = $dto->toModel(Theme::class);
            $theme->save();

            if ($dto->primary_logo) {
                $theme->addMediaFromDisk($dto->primary_logo->key, 'central')
                    ->usingFileName($dto->primary_logo->uuid . '.' . $dto->primary_logo->extension)
                    ->toMediaCollection('primary-logos');
            }

            if ($dto->contrast_primary_logo) {
                $theme->addMediaFromDisk($dto->contrast_primary_logo->key, 'central')
                    ->usingFileName($dto->contrast_primary_logo->uuid . '.' . $dto->contrast_primary_logo->extension)
                    ->toMediaCollection('contrast-primary-logos');
            }

            if ($dto->favicon) {
                $theme->addMediaFromDisk($dto->favicon->key, 'central')
                    ->usingFileName($dto->favicon->uuid . '.' . $dto->favicon->extension)
                    ->toMediaCollection('favicons');
            }

            if ($dto->reduced_logo) {
                $theme->addMediaFromDisk($dto->reduced_logo->key, 'central')
                    ->usingFileName($dto->reduced_logo->uuid . '.' . $dto->reduced_logo->extension)
                    ->toMediaCollection('reduced-logos');
            }

            if ($dto->contrast_reduced_logo) {
                $theme->addMediaFromDisk($dto->contrast_reduced_logo->key, 'central')
                    ->usingFileName($dto->contrast_reduced_logo->uuid . '.' . $dto->contrast_reduced_logo->extension)
                    ->toMediaCollection('contrast-reduced-logos');
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $theme;
    }
}
