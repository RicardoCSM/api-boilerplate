<?php

declare(strict_types=1);

namespace Modules\Tenant\DTOs;

use Illuminate\Validation\Rule;
use Modules\Common\Core\DTOs\Concerns\Utils;
use Modules\Common\Core\DTOs\UploadedFileDTO;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UpdateThemeDTO extends ValidatedDTO
{
    use Utils;

    public ?string $title;

    public ?UploadedFileDTO $primary_logo;

    public ?UploadedFileDTO $contrast_primary_logo;

    public ?UploadedFileDTO $favicon;

    public ?UploadedFileDTO $reduced_logo;

    public ?UploadedFileDTO $contrast_reduced_logo;

    public ?string $institutional_website_url;

    public ?string $primary_color_light;

    public ?string $secondary_color_light;

    public ?string $primary_color_dark;

    public ?string $secondary_color_dark;

    public ?string $app_store_url;

    public ?string $google_play_url;

    public ?bool $active;

    public ?string $to_activate_id;

    protected function rules(): array
    {
        return [
            'title' => ['sometimes', 'nullable', 'string'],
            'primary_logo' => ['sometimes', 'nullable', 'array'],
            'primay_logo.extension' => ['sometimes', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
            'contrast_primary_logo' => ['sometimes', 'nullable', 'array'],
            'contrast_primary_logo.extension' => ['sometimes', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
            'favicon' => ['sometimes', 'nullable', 'array'],
            'favicon.extension' => ['sometimes', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
            'reduced_logo' => ['sometimes', 'nullable', 'array'],
            'reduced_logo.extension' => ['sometimes', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
            'contrast_reduced_logo' => ['sometimes', 'nullable', 'array'],
            'contrast_reduced_logo.extension' => ['sometimes', 'string', Rule::in(['jpeg', 'jpg', 'png'])],
            'institutional_website_url' => ['sometimes', 'nullable', 'url'],
            'primary_color_light' => ['sometimes', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'secondary_color_light' => ['sometimes', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'primary_color_dark' => ['sometimes', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'secondary_color_dark' => ['sometimes', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'app_store_url' => ['sometimes', 'nullable', 'url'],
            'google_play_url' => ['sometimes', 'nullable', 'url'],
            'active' => ['sometimes', 'nullable', 'boolean'],
            'to_activate_id' => ['sometimes', 'uuid', 'exists:themes,uuid'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'primary_logo' => new DTOCast(UploadedFileDTO::class),
            'contrast_primary_logo' => new DTOCast(UploadedFileDTO::class),
            'favicon' => new DTOCast(UploadedFileDTO::class),
            'reduced_logo' => new DTOCast(UploadedFileDTO::class),
            'contrast_reduced_logo' => new DTOCast(UploadedFileDTO::class),
            'active' => new BooleanCast(),
        ];
    }
}
