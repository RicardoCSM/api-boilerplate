<?php

declare(strict_types=1);

namespace Modules\Tenant\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Tenant\Support\Bucket;
use Stancl\Tenancy\Database\Contracts\TenantWithDatabase;

class CreateTenantBucket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected TenantWithDatabase|Model $tenant;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        (new Bucket($this->tenant))->createTenantBucket()->getBucketName();
    }

    public function tags(): array
    {
        return [
            'tenant:' . $this->tenant->id,
        ];
    }
}
