<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Support;

use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\Document;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;
use Google\Protobuf\Internal\RepeatedField;
use Illuminate\Support\Facades\Storage;
use Modules\Common\Core\DTOs\UploadedFileDTO;

readonly class DocumentAI
{
    public static function processDocument(UploadedFileDTO $dto, string $processorId): ?Document
    {
        $projectId = env('DOCUMENT_AI_PROJECT_ID');
        $location = env('DOCUMENT_AI_LOCATION');

        $name = "projects/{$projectId}/locations/{$location}/processors/{$processorId}";
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path() . '/' . env('GOOGLE_APPLICATION_CREDENTIALS'));

        $filePath = Storage::disk('central')->path($dto->key);
        $encodedFile = file_get_contents($filePath);
        $fileType = mime_content_type($filePath);
        $client = new DocumentProcessorServiceClient();

        $rawDocument = new RawDocument();
        $rawDocument->setContent($encodedFile);
        $rawDocument->setMimeType($fileType);

        $testRequest = new ProcessRequest([
            'name' => $name,
            'skip_human_review' => true,
            'raw_document' => $rawDocument,
        ]);

        $response = $client->processDocument($testRequest);
        $document = $response->getDocument();

        return $document;
    }

    public static function repeatedFieldToArray(RepeatedField $repeatedField): array
    {
        $array = [];
        foreach ($repeatedField as $item) {
            $array[] = $item;
        }

        return $array;
    }

    public static function getValueByType(array $entities, string $type): ?string
    {
        foreach ($entities as $entity) {
            if ($entity->getType() === $type) {
                if (! empty($entity)) {
                    return $entity->getMentionText();
                }

                return null;

            }
        }

        return null;
    }
}
