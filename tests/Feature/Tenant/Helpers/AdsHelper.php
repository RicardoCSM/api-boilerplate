<?php

declare(strict_types=1);

namespace Tests\Feature\Tenant\Helpers;

use Modules\Tenant\Models\Ads;

class AdsHelper
{
    public static function createTestAds(): Ads
    {
        $ads = new Ads([
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'background_image_url' => fake()->url(),
            'button_text' => fake()->sentence(),
            'button_url' => fake()->url(),
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'order' => 1,
            'active' => true,
        ]);

        $ads->save();

        return $ads;
    }

    public static function dumbAdsData(): array
    {
        return [
            'title' => 'foo-title',
            'description' => 'foo description',
            'background_image_url' => 'https://example.com/foo.jpg',
            'button_text' => 'foo button',
            'button_url' => 'https://example.com/foo',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'order' => 1,
            'active' => true,
        ];
    }
}
