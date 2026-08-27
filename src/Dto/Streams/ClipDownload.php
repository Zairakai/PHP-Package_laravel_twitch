<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a clip's temporary download URLs, as returned by Get Clips Download.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-clips-download
 */
#[MapInputName(SnakeCaseMapper::class)]
class ClipDownload extends Data
{
    public function __construct(
        /**
         * @var string ID of the clip
         */
        public string $clipId,

        /**
         * @var string|null Landscape download URL, null if not available
         */
        public ?string $landscapeDownloadUrl,

        /**
         * @var string|null Portrait download URL, null if not available
         */
        public ?string $portraitDownloadUrl,
    ) {}
}
