<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitch_users');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twitch_users', function (Blueprint $table) {
            $table->id();
            $table->string('twitch_id')->unique();
            $table->string('login')->unique();
            $table->string('display_name');
            $table->string('type')->default('');
            $table->string('broadcaster_type')->default('');
            $table->text('description')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->string('offline_image_url')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('created_at_twitch')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('scopes')->nullable();
            $table->timestamps();

            $table->index(['twitch_id', 'login']);
            $table->index('expires_at');
        });
    }
};
