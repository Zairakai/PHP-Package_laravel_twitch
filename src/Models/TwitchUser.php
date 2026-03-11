<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon|null        $expires_at
 * @property array<string>|null $scopes
 */
class TwitchUser extends Model
{
    /** @use HasFactory<Factory<static>> */
    use HasFactory;

    protected $fillable = [
        'twitch_id',
        'login',
        'display_name',
        'type',
        'broadcaster_type',
        'description',
        'profile_image_url',
        'offline_image_url',
        'email',
        'created_at_twitch',
        'access_token',
        'refresh_token',
        'expires_at',
        'scopes',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected $table = 'twitch_users';

    /**
     * Find user by login (username).
     */
    public static function findByLogin(string $login): ?self
    {
        return static::where('login', $login)->first();
    }

    /**
     * Find user by Twitch ID.
     */
    public static function findByTwitchId(string $twitchId): ?self
    {
        return static::where('twitch_id', $twitchId)->first();
    }

    /**
     * Check if user has specific scope.
     */
    public function hasScope(string $scope): bool
    {
        return in_array($scope, $this->scopes ?? [], true);
    }

    /**
     * Check if the access token is still valid.
     */
    public function isTokenValid(): bool
    {
        return $this->expires_at instanceof Carbon && $this->expires_at->isFuture();
    }

    /**
     * Update token information.
     *
     * @param array<string, mixed> $tokenData
     */
    public function updateTokens(array $tokenData): self
    {
        /** @var string $accessToken */
        $accessToken = $tokenData['access_token'];

        /** @var string|null $newRefreshToken */
        $newRefreshToken = $tokenData['refresh_token'] ?? null;

        /** @var int $expiresIn */
        $expiresIn = $tokenData['expires_in'];

        $this->update([
            'access_token'  => $accessToken,
            'refresh_token' => is_string($newRefreshToken) ? $newRefreshToken : $this->refresh_token,
            'expires_at'    => now()->addSeconds($expiresIn),
            'scopes'        => $tokenData['scope'] ?? $this->scopes,
        ]);

        return $this;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'twitch_id'         => 'string',
            'created_at_twitch' => 'datetime',
            'expires_at'        => 'datetime',
            'scopes'            => 'array',
        ];
    }
}
