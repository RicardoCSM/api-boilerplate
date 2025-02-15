<?php

declare(strict_types=1);

namespace Modules\Tenant\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\Models\Tenant;

class InactiveStatusAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function __invoke(): void
    {
        Tenant::all()->each(function ($tenant) {
            tenancy()->initialize($tenant);

            DB::table('ads')
                ->whereNotNull('end_date')
                ->where('end_date', '<', now())
                ->where('active', true)
                ->update(['active' => false]);
        });
    }
}
