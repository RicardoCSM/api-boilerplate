<?php

declare(strict_types=1);

namespace Tests\Feature\Tenant\Helpers;

use Modules\Tenant\Models\Theme;

class ThemesHelper
{
    public static function createTestTheme(): Theme
    {
        $theme = new Theme([
            'title' => fake()->sentence(),
            'institutional_website_url' => fake()->url(),
            'primary_color_light' => fake()->hexColor(),
            'secondary_color_light' => fake()->hexColor(),
            'primary_color_dark' => fake()->hexColor(),
            'secondary_color_dark' => fake()->hexColor(),
            'app_store_url' => fake()->url(),
            'google_play_url' => fake()->url(),
            'active' => true,
        ]);

        $theme->save();

        return $theme;
    }

    public static function dumbThemeData(): array
    {
        return [
            'title' => 'foo-title',
            'institutional_website_url' => 'https://example.com/foo',
            'primary_color_light' => '#ffffff',
            'secondary_color_light' => '#ffffff',
            'primary_color_dark' => '#ffffff',
            'secondary_color_dark' => '#ffffff',
            'app_store_url' => 'https://example.com/foo',
            'google_play_url' => 'https://example.com/foo',
            'active' => true,
        ];
    }
}
