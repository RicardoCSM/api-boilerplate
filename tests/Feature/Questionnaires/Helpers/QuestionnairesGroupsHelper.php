<?php

declare(strict_types=1);

namespace Tests\Feature\Questionnaires\Helpers;

use Modules\Questionnaires\Models\QuestionnairesGroup;

class QuestionnairesGroupsHelper
{
    public static function createTestQuestionnairesGroup(): QuestionnairesGroup
    {
        $questionnairesGroup = new QuestionnairesGroup([
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'icon' => fake()->word(),
            'order' => QuestionnairesGroup::max('order') + 1,
            'active' => true,
        ]);

        $questionnairesGroup->save();

        return $questionnairesGroup;
    }

    public static function dumbQuestionnairesGroupData(): array
    {
        return [
            'title' => 'test-questionnaires-group',
            'description' => 'test description',
            'icon' => 'test-icon',
            'order' => QuestionnairesGroup::max('order') + 1,
            'active' => true,
        ];
    }
}
