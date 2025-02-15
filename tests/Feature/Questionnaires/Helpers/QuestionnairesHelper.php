<?php

declare(strict_types=1);

namespace Tests\Feature\Questionnaires\Helpers;

use Modules\Questionnaires\Models\Questionnaire;
use Modules\Questionnaires\Models\QuestionnairesGroup;

class QuestionnairesHelper
{
    public static function createTestQuestionnaire(QuestionnairesGroup $questionnairesGroup): Questionnaire
    {
        $questionnaire = new Questionnaire([
            'questionnaires_group_id' => $questionnairesGroup->id,
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'active' => true,
            'elements' => [],
            'version' => 1,
        ]);

        $questionnaire->save();

        return $questionnaire;
    }

    public static function dumbQuestionnaireData(QuestionnairesGroup $questionnairesGroup): array
    {
        return [
            'questionnaires_group_id' => $questionnairesGroup->id,
            'title' => 'test-questionnaire',
            'description' => 'test description',
            'active' => true,
            'elements' => [],
            'version' => 1,
        ];
    }
}
