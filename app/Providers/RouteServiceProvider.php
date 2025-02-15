<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Modules\Common\Core\Support\Formatter;

final class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->configureIndexRoute();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            'api',
            fn (Request $request) => Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip())
        );
    }

    private function configureIndexRoute(): void
    {
        Route::get(self::HOME, function () {
            $data = [
                'application' => config('app.name'),
                'status' => Response::HTTP_OK,
                'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
            ];

            if (! App::environment('local', 'testing')) {
                return response()->json($data);
            }

            $data = [
                ...$data,
                'environment' => config('app.env'),
                'php_version' => phpversion(),
                'laravel_version' => App::version(),
            ];

            return response()->json($data);
        })->name('login');
    }
}
