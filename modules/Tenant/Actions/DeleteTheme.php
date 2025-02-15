<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\Exceptions\ActiveThemeDeletionException;

final readonly class DeleteTheme
{
    public function __construct(private FetchTheme $fetchTheme) {}

    public function handle(string $uuid): void
    {
        $theme = $this->fetchTheme->handle($uuid);

        throw_if($theme->active, new ActiveThemeDeletionException());

        try {
            DB::beginTransaction();

            $theme->media->each->move($theme, 'trash');

            $theme->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
