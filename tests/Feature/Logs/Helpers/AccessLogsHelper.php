<?php

declare(strict_types=1);

namespace Tests\Feature\Logs\Helpers;

use Modules\Common\Core\Support\Modules;
use Modules\Common\Logs\Models\AccessLog;
use Modules\Common\Logs\Support\AccessActions;

class AccessLogsHelper
{
    public static function createTestAccessLog(): AccessLog
    {
        $accessLog = new AccessLog([
            'action' => AccessActions::DATATABLE_VIEW,
            'module' => Modules::USERS,
            'user_name' => fake()->name(),
            'message' => fake()->sentence(),
        ]);

        $accessLog->save();

        return $accessLog;
    }

    public static function dumbAccessLogData(): array
    {
        return [
            'action' => AccessActions::DATATABLE_VIEW,
            'module' => Modules::USERS,
            'user_name' => fake()->name(),
            'message' => 'fake-message',
        ];
    }
}
