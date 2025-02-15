<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Models\User;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->bootCollectionMacros();
        $this->bootBlueprintMacros();
        $this->bootRouteMacros();
    }

    private function bootCollectionMacros(): void
    {
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            /** @var \Illuminate\Support\Collection $this */
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $total ? $this : $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    private function bootBlueprintMacros(): void
    {
        Blueprint::macro('userActions', function () {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->foreignId('created_by')->nullable()->constrained(table: User::getModelTable());
            $this->foreignId('updated_by')->nullable()->constrained(table: User::getModelTable());
            $this->foreignId('deleted_by')->nullable()->constrained(table: User::getModelTable());
        });
    }

    private function bootRouteMacros(): void
    {
        Route::macro('protectFromImpersonation', function () {
            /** @var \Illuminate\Routing\Route $this */

            return $this->middleware('impersonate.protect');
        });
    }
}
