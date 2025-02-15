<?php

declare(strict_types=1);

namespace Modules\Common\Core\Controllers;

use Laravel\Vapor\Http\Controllers\SignedStorageUrlController as VaporSignedStorageUrlController;

final class SignedStorageUrlController extends VaporSignedStorageUrlController
{
    // protected function getKey(string $uuid): string
    // {
    //     return config('filesystems.disks.s3.root') . '/tmp/' . $uuid;
    // }
}
