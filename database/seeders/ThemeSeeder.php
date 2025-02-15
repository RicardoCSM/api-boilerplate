<?php

declare(strict_types=1);

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Tenant\Models\Theme;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $theme = Theme::create([
            'title' => 'Padrão',
            'primary_color_light' => '#1B134B',
            'secondary_color_light' => '#A1A3AF',
            'primary_color_dark' => '#A1A3AF',
            'secondary_color_dark' => '#1B134B',
        ]);

        try {
            if (! Storage::disk('central')->exists('assets/tenant/theme/default')) {
                return;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return;
        }

        if (Storage::disk('central')->exists('assets/tenant/theme/default/primary-logo.png')) {
            $theme->addMediaFromDisk('assets/tenant/theme/default/primary-logo.png', 'central')
                ->preservingOriginal()
                ->toMediaCollection('primary-logos');
        }

        if (Storage::disk('central')->exists('assets/tenant/theme/default/contrast-primary-logo.png')) {
            $theme->addMediaFromDisk('assets/tenant/theme/default/contrast-primary-logo.png', 'central')
                ->preservingOriginal()
                ->toMediaCollection('contrast-primary-logos');
        }

        if (Storage::disk('central')->exists('assets/tenant/theme/default/reduced-logo.png')) {
            $theme->addMediaFromDisk('assets/tenant/theme/default/reduced-logo.png', 'central')
                ->preservingOriginal()
                ->toMediaCollection('reduced-logos');
        }

        if (Storage::disk('central')->exists('assets/tenant/theme/default/contrast-reduced-logo.png')) {
            $theme->addMediaFromDisk('assets/tenant/theme/default/contrast-reduced-logo.png', 'central')
                ->preservingOriginal()
                ->toMediaCollection('contrast-reduced-logos');
        }

        if (Storage::disk('central')->exists('assets/tenant/theme/default/favicon.png')) {
            $theme->addMediaFromDisk('assets/tenant/theme/default/favicon.png', 'central')
                ->preservingOriginal()
                ->toMediaCollection('favicons');
        }
    }
}
