<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Actions;

use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Exceptions\InvalidDocumentException;
use Modules\DocumentAI\Support\DocumentAI;

final readonly class GetType
{
    public function handle(DocumentAIDTO $dto): array
    {
        $processorId = env('DOCUMENT_AI_TYPE_PROCESSOR_ID');
        $document = DocumentAI::processDocument($dto->file, $processorId);
        $entities = DocumentAI::repeatedFieldToArray($document->getEntities());

        $type = $this->buildType($entities);

        if ($type === null) {
            throw new InvalidDocumentException();
        }

        return [
            'type' => $type,
        ];
    }

    public function buildType(array $entities): ?string
    {
        $highestConfidence = 0.0;
        $type = null;

        foreach ($entities as $entity) {
            $confidence = $entity->getConfidence();
            if ($confidence > $highestConfidence) {
                $highestConfidence = $confidence;
                $type = $entity->getType();
            }
        }

        if (empty($type) || $highestConfidence < 0.5) {
            return null;
        }

        return $type;
    }
}
