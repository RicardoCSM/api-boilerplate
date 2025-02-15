<?php

declare(strict_types=1);

namespace Modules\Common\Core\Actions;

final readonly class DeleteMedia
{
    public function __construct(private FetchMedia $fetchMedia) {}

    public function handle(string $uuid): void
    {
        $media = $this->fetchMedia->handle($uuid);
        $media->move($media->model, 'trash');
    }
}
