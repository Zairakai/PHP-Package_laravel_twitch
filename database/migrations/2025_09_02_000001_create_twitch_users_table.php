<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists($this->table());
    }

    /**
     * The connection of the tokens: `twitch.database.connection`, the default connection of the application when null.
     */
    public function getConnection(): ?string
    {
        $connection = config('twitch.database.connection');

        return is_string($connection) && '' !== $connection
            ? $connection
            : null;
    }

    public function up(): void
    {
        Schema::create($this->table(), function (Blueprint $table): void {
            $table->id();

            // The ID of the user is what never changes: the login can be changed, and taken by someone else.
            $table->string('twitch_id')->unique();
            $table->string('login')->index();
            $table->string('display_name');
            $table->string('type')->default('');
            $table->string('broadcaster_type')->default('');
            $table->text('description')->nullable();
            $table->text('profile_image_url')->nullable();
            $table->text('offline_image_url')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('created_at_twitch')->nullable();

            // Encrypted by the model (the value is longer than the token): hence text columns
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->json('scopes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * The name of the table: `twitch.database.table_prefix` and `users`.
     */
    private function table(): string
    {
        $prefix = config('twitch.database.table_prefix');

        return (is_string($prefix) ? $prefix : 'twitch_') . 'users';
    }
};
