<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Modules\Common\Core\Support\Formatter;
use Tests\TestCase;

class ApplicationUpTest extends TestCase
{
    public function test_that_application_is_up(): void
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'application' => config('app.name'),
            'status' => Response::HTTP_OK,
            'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
            'environment' => config('app.env'),
            'php_version' => phpversion(),
            'laravel_version' => App::version(),
        ]);
    }
}
