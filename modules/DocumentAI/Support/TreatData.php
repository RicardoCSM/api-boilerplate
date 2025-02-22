<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Support;

use DateTime;
use Illuminate\Support\Facades\Http;

readonly class TreatData
{
    public static function formatDate(string $date): string|array
    {
        $formats = [
            'd/m/y',
            'd-m-y',
            'd - m - Y',
            'd/m/Y',
            'd.m.Y',
            'd.m.y',
            'd/\\m/Y',
            'd-M-y',
            'd-M-Y',
            'd/F/y',
            'd/F/Y',
        ];

        foreach ($formats as $format) {
            $formatedDate = DateTime::createFromFormat($format, $date);
            if ($formatedDate !== false) {
                return $formatedDate->format('d/m/Y');
            }
        }

        return [
            'data' => $date,
            'message' => 'Valor incerto!',
        ];
    }

    public static function formatLocal(string $local): string|array
    {
        $local = trim(preg_replace('/\s+/', ' ', $local));
        $patterns = [
            '/([\p{L}\s]+)\s?\/\s?([\p{L}\s]{2,})/iu',
            '/([\p{L}\s]+)\s?-\s?([\p{L}]{2})/iu',
            '/([\p{L}\s]+)-([\p{L}]{2})/iu',
            '/([\p{L}\s]+)\s?[\.\-]\s?([\p{L}]{2})/iu',
            '/([\p{L}\s]+),?\s?([\p{L}]{2})/iu',
            '/([\p{L}\s]+)\s?,\s?([\p{L}]{2})/iu',
            '/([\p{L}\s]+)([\p{L}]{2})/iu',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $local, $matches)) {
                $city = ucwords(trim($matches[1]));
                $uf = strtoupper(trim($matches[2]));
                if (self::verifyCityInState($city, $uf)) {
                    return ['cidade' => $city, 'uf' => $uf];
                }

                return [
                    'cidade' => $city,
                    'uf' => $uf,
                    'message' => 'Valor incerto!',
                ];

            }
        }

        return null;
    }

    private static function verifyCityInState($city, $uf): bool
    {
        $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");

        if ($response->successful()) {
            $cities = $response->json();

            foreach ($cities as $cityData) {
                if (strcoll(mb_strtolower($cityData['nome'], 'UTF-8'), mb_strtolower($city, 'UTF-8')) === 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
