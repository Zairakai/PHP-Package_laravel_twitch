<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

/**
 * Twitch Extensions API methods.
 *
 * Extensions are interactive overlays and panels that enhance the Twitch viewer experience.
 * Note: Most of these endpoints require an Extension Client ID and JWT signed with the extension secret.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-extension-configuration-segment
 */
trait HasExtensionsMethods
{
    /**
     * Create a shared secret for the extension (rotates signing key).
     *
     * Requires: signed JWT from an Extension
     *
     * @param int $delay Seconds before the previous secret expires (300–900)
     *
     * @return array<string, mixed>
     */
    public function createExtensionSecret(string $extensionId, int $delay = 300): array
    {
        return $this->makeRequest('POST', '/extensions/jwt/secrets', [
            'extension_id' => $extensionId,
            'delay'        => $delay,
        ]);
    }

    /**
     * Get the specified extension.
     *
     * Requires: signed JWT from an Extension
     *
     * @return array<string, mixed>
     */
    public function getExtension(string $extensionId, ?string $extensionVersion = null): array
    {
        $params = [
            'extension_id' => $extensionId,
        ];

        if (null !== $extensionVersion) {
            $params['extension_version'] = $extensionVersion;
        }

        return $this->makeRequest(
            'GET',
            '/extensions',
            $params,
        );
    }

    /**
     * Get the list of Bits products that belongs to the extension.
     *
     * Requires: app access token
     *
     * @return array<string, mixed>
     */
    public function getExtensionBitsProducts(string $extensionClientId, bool $shouldIncludeAll = false): array
    {
        return $this->makeRequest('GET', '/bits/extensions', [
            'extension_client_id' => $extensionClientId,
            'should_include_all'  => $shouldIncludeAll,
        ]);
    }

    /**
     * Get a segment of the extension's configuration (global, broadcaster, or developer).
     *
     * Requires: signed JWT from an Extension
     *
     * @param string      $extensionId   Extension client ID
     * @param string      $segment       global, broadcaster, or developer
     * @param string|null $broadcasterId Required for broadcaster/developer segments
     *
     * @return array<string, mixed>
     */
    public function getExtensionConfigurationSegment(
        string $extensionId,
        string $segment,
        ?string $broadcasterId = null,
    ): array {
        $params = [
            'extension_id' => $extensionId,
            'segment'      => $segment,
        ];

        if (null !== $broadcasterId) {
            $params['broadcaster_id'] = $broadcasterId;
        }

        return $this->makeRequest(
            'GET',
            '/extensions/configurations',
            $params,
        );
    }

    /**
     * Get a list of broadcasters that are streaming live and have installed or activated the extension.
     *
     * Requires: signed JWT from an Extension
     *
     * @return array<string, mixed>
     */
    public function getExtensionLiveChannels(
        string $extensionId,
        int $first = 20,
        ?string $after = null,
    ): array {
        $params = [
            'extension_id' => $extensionId,
            'first'        => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        return $this->makeRequest(
            'GET',
            '/extensions/live',
            $params,
        );
    }

    /**
     * Get the list of secret tokens for the extension.
     *
     * Requires: signed JWT from an Extension
     *
     * @return array<string, mixed>
     */
    public function getExtensionSecrets(string $extensionId): array
    {
        return $this->makeRequest('GET', '/extensions/jwt/secrets', [
            'extension_id' => $extensionId,
        ]);
    }

    /**
     * Get the specified extension's most current version. Released extensions only.
     *
     * Requires: app access token
     *
     * @return array<string, mixed>
     */
    public function getReleasedExtension(string $extensionId, ?string $extensionVersion = null): array
    {
        $params = [
            'extension_id' => $extensionId,
        ];

        if (null !== $extensionVersion) {
            $params['extension_version'] = $extensionVersion;
        }

        return $this->makeRequest(
            'GET',
            '/extensions/released',
            $params,
        );
    }

    /**
     * Send a chat message to the broadcaster's chat room on behalf of an extension.
     *
     * Requires: signed JWT from an Extension
     */
    public function sendExtensionChatMessage(
        string $broadcasterId,
        string $extensionId,
        string $extensionVersion,
        string $text,
    ): void {
        $this->makeRequest('POST', '/extensions/chat', [
            'broadcaster_id'    => $broadcasterId,
            'extension_id'      => $extensionId,
            'extension_version' => $extensionVersion,
            'text'              => $text,
        ]);
    }

    /**
     * Send a PubSub message to one or more clients listening to the broadcaster's channel.
     *
     * Requires: signed JWT from an Extension, given with setAccessToken(): it carries the extension and the rights.
     *
     * @param string        $extensionId       Not sent (the JWT names the extension): kept so that existing calls still compile
     * @param array<string> $targets           broadcast, global, or whisper-<user ID>
     * @param bool|null     $isGlobalBroadcast true: to every channel with the extension (the broadcaster is then not sent)
     */
    public function sendExtensionPubSubMessage(
        string $broadcasterId,
        string $extensionId,
        string $message,
        array $targets = [
            'broadcast',
        ],
        ?bool $isGlobalBroadcast = null,
    ): void {
        $body = [
            'target'  => $targets,
            'message' => $message,
        ];

        // A global broadcast has no broadcaster: Twitch refuses broadcaster_id with is_global_broadcast.
        if (true === $isGlobalBroadcast) {
            $body['is_global_broadcast'] = true;
        }
        else {
            $body['broadcaster_id'] = $broadcasterId;
        }

        $this->makeRequest(
            'POST',
            '/extensions/pubsub',
            $body,
        );
    }

    /**
     * Set a configuration segment for an extension.
     *
     * Requires: signed JWT from an Extension
     *
     * @param string      $extensionId   Extension client ID
     * @param string      $segment       global, broadcaster, or developer
     * @param string|null $broadcasterId Required for broadcaster/developer segments
     * @param string|null $content       Serialized JSON string (max 5KB)
     * @param string|null $version       Configuration version for optimistic locking
     */
    public function setExtensionConfigurationSegment(
        string $extensionId,
        string $segment,
        ?string $broadcasterId = null,
        ?string $content = null,
        ?string $version = null,
    ): void {
        $params = [
            'extension_id' => $extensionId,
            'segment'      => $segment,
        ];

        if (null !== $broadcasterId) {
            $params['broadcaster_id'] = $broadcasterId;
        }

        if (null !== $content) {
            $params['content'] = $content;
        }

        if (null !== $version) {
            $params['version'] = $version;
        }

        $this->makeRequest(
            'PUT',
            '/extensions/configurations',
            $params,
        );
    }

    /**
     * Enable activation of a specific extension on the broadcaster's channel.
     *
     * Requires: signed JWT from an Extension, given with setAccessToken().
     *
     * @param string $requiredConfiguration The `required_configuration` string of the new extension version
     */
    public function setExtensionRequiredConfiguration(
        string $broadcasterId,
        string $extensionId,
        string $extensionVersion,
        string $requiredConfiguration,
    ): void {
        $this->makeRequest('PUT', '/extensions/required_configuration', [
            'broadcaster_id'         => $broadcasterId,
            'extension_id'           => $extensionId,
            'extension_version'      => $extensionVersion,
            'required_configuration' => $requiredConfiguration,
        ]);
    }

    /**
     * Add or update a Bits product that the extension created.
     *
     * Requires: app access token
     *
     * @param array<string, mixed> $data Product data (sku, cost, in_development, display_name, etc.)
     *
     * @return array<string, mixed>
     */
    public function updateExtensionBitsProduct(string $extensionClientId, array $data): array
    {
        return $this->makeRequest('PUT', '/bits/extensions', array_merge([
            'extension_client_id' => $extensionClientId,
        ], $data));
    }
}
