<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Modules\Questionnaires\DTOs\CreateQuestionnaireResponseDTO;
use Modules\Questionnaires\Models\QuestionnaireResponse;

final readonly class CreateQuestionnaireResponse
{
    public function __construct(private FetchQuestionnaire $fetchQuestionnaire) {}

    public function handle(CreateQuestionnaireResponseDTO $dto): QuestionnaireResponse
    {
        $questionnaire = $this->fetchQuestionnaire->handle($dto->questionnaire_id);

        $questionnaireResponse = $dto->toModel(QuestionnaireResponse::class);
        $questionnaireResponse->questionnaire_id = $questionnaire->id;
        $questionnaireResponse->version = $questionnaire->version;

        $questionnaireResponse->save();

        return $questionnaireResponse;
    }
}
