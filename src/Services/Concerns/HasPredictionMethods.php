<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Predictions\Prediction;
use Zairakai\LaravelTwitch\Dto\Predictions\Requests\CreatePredictionRequest;

/**
 * Twitch Predictions API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-predictions
 */
trait HasPredictionMethods
{
    /**
     * Create a Channel Points prediction for a broadcaster.
     *
     * Requires: channel:manage:predictions
     */
    public function createPrediction(CreatePredictionRequest $createPredictionRequest): Prediction
    {
        /** @var array<string, mixed> $requestData */
        $requestData = $createPredictionRequest->toArray();
        $raw         = $this->makeRequest('POST', '/predictions', $requestData);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Prediction::from($items[0]);
    }

    /**
     * Lock, resolve, or cancel a prediction.
     *
     * Requires: channel:manage:predictions
     *
     * @param string      $status           RESOLVED or CANCELED
     * @param string|null $winningOutcomeId Required when status is RESOLVED
     */
    public function endPrediction(
        string $broadcasterId,
        string $predictionId,
        string $status,
        ?string $winningOutcomeId = null,
    ): Prediction {
        $body = [
            'broadcaster_id' => $broadcasterId,
            'id'             => $predictionId,
            'status'         => $status,
        ];

        if (null !== $winningOutcomeId) {
            $body['winning_outcome_id'] = $winningOutcomeId;
        }

        $raw = $this->makeRequest('PATCH', '/predictions', $body);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Prediction::from($items[0]);
    }

    /**
     * Get information about predictions for a broadcaster's channel.
     *
     * Requires: channel:read:predictions
     *
     * @param string|array<string>|null $predictionIds Filter by specific prediction ID(s)
     *
     * @return PaginatedResult<Prediction>
     */
    public function getPredictions(
        string $broadcasterId,
        string|array|null $predictionIds = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $predictionIds) {
            $params['id'] = $predictionIds;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/predictions', $params);

        return PaginatedResult::fromRaw($raw, Prediction::class);
    }
}
