<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Modules\Questionnaires\DTOs\CreateQuestionnaireDTO;
use Modules\Questionnaires\Models\Questionnaire;

final readonly class CreateQuestionnaire
{
    public function handle(CreateQuestionnaireDTO $dto): Questionnaire
    {
        $questionnaire = $dto->toModel(Questionnaire::class);
        $questionnaire->save();

        return $questionnaire;
    }
}
