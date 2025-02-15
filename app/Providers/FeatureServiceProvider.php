<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Modules\Common\Core\Support\RedisFeatureDriver;

final class FeatureServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Feature::extend('redis', function (Application $app) {
            return new RedisFeatureDriver(
                $app->make('redis'),
                $app->make('events'),
                []
            );
        });

        Feature::resolveScopeUsing(fn () => tenant());
    }
}
