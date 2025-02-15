<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Modules\Questionnaires\DTOs\QuestionnaireVersionDTO;
use Modules\Questionnaires\Models\Questionnaire;

final readonly class FetchQuestionnaire
{
    public function handle(string $uuid, ?QuestionnaireVersionDTO $dto = null): Questionnaire
    {

        if ($dto !== null && isset($dto->version)) {
            return Questionnaire::where('uuid', $uuid)
                ->where('version', $dto->version)
                ->firstOrFail();
        }

        return Questionnaire::where('uuid', $uuid)
            ->orderByDesc('version')
            ->firstOrFail();
    }
}
