<?php

declare(strict_types=1);

namespace Modules\Tenant\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Concerns\UsableWithEarlyIdentification;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;
use Stancl\Tenancy\Overrides\TenancyUrlGenerator;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByRequestData extends IdentificationMiddleware
{
    use UsableWithEarlyIdentification;

    public static string $header = 'X-Domain';

    public static string $cookie = 'X-Domain';

    public static string $queryParameter = 'domain';

    public static ?Closure $onFail = null;

    public function __construct(
        protected Tenancy $tenancy,
        protected DomainTenantResolver $resolver,
    ) {}

    /** @return \Illuminate\Http\Response|mixed */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->shouldBeSkipped(tenancy()->getRoute($request))) {
            // Allow accessing central route in kernel identification
            return $next($request);
        }

        // Used with *route-level* identification, takes precedence over what may have been configured for global stack middleware
        TenancyUrlGenerator::$prefixRouteNames = false;

        if ($request->method() !== 'OPTIONS') {
            return $this->initializeTenancy($request, $next, $this->getPayload($request));
        }

        return $next($request);
    }

    /**
     * Check if the request has the tenant payload.
     */
    public function requestHasTenant(Request $request): bool
    {
        return (bool) $this->getPayload($request);
    }

    protected function getPayload(Request $request): ?string
    {
        if (static::$header && $request->hasHeader(static::$header)) {
            $payload = $request->header(static::$header);
        } elseif (static::$queryParameter && $request->has(static::$queryParameter)) {
            $payload = $request->get(static::$queryParameter);
        } elseif (static::$cookie && $request->hasCookie(static::$cookie)) {
            $payload = $request->cookie(static::$cookie);
        } else {
            $payload = null;
        }

        if (is_string($payload) || is_null($payload)) {
            return $payload;
        }

        throw new TenantCouldNotBeIdentifiedByRequestDataException($payload);
    }
}
