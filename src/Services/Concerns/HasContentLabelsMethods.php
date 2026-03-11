<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\ContentLabels\ContentClassificationLabel;

/**
 * Twitch Content Classification Labels API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-content-classification-labels
 */
trait HasContentLabelsMethods
{
    /**
     * Get information about Twitch content classification labels.
     *
     * Requires: no scope
     *
     * @param string $locale The locale to retrieve labels in (e.g. 'en-US', 'fr-FR')
     *
     * @return DataCollection<int, ContentClassificationLabel>
     */
    public function getContentClassificationLabels(string $locale = 'en-US'): DataCollection
    {
        $raw = $this->makeRequest('GET', '/content_classification_labels', [
            'locale' => $locale,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, ContentClassificationLabel> $dataCollection */
        $dataCollection = ContentClassificationLabel::collect($items, DataCollection::class);

        return $dataCollection;
    }
}
