<?php

declare(strict_types=1);

namespace Tests\Feature\Questionnaires\Helpers;

use Modules\Questionnaires\Models\QuestionnaireResponse;

class QuestionnaireResponsesHelper
{
    public static function createTestQuestionnaireResponse(): QuestionnaireResponse
    {
        $questionnaire = QuestionnairesHelper::createTestQuestionnaire(QuestionnairesGroupsHelper::createTestQuestionnairesGroup());

        $questionnaireResponse = new QuestionnaireResponse([
            'questionnaire_id' => $questionnaire->id,
            'version' => $questionnaire->version,
            'started_at' => now(),
            'answers' => [],
        ]);

        $questionnaireResponse->save();

        return $questionnaireResponse;
    }

    public static function dumbQuestionnaireResponseData(): array
    {
        $questionnaire = QuestionnairesHelper::createTestQuestionnaire(QuestionnairesGroupsHelper::createTestQuestionnairesGroup());

        return [
            'questionnaire_id' => $questionnaire->id,
            'version' => $questionnaire->version,
            'started_at' => now(),
            'answers' => [],
        ];
    }
}
