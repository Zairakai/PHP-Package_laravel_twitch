<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PublishLangCommandTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->directory = sys_get_temp_dir() . '/twitch-lang-' . uniqid();
        $this->app?->useLangPath($this->directory);
    }

    protected function tearDown(): void
    {
        new Filesystem()->deleteDirectory($this->directory);

        parent::tearDown();
    }

    #[Test]
    public function it_asks_for_a_language_when_none_is_given(): void
    {
        $this->invoke('twitch:lang')->expectsOutputToContain('Give the languages')->assertFailed();
    }

    #[Test]
    public function it_does_not_replace_a_file_that_the_application_changed_unless_forced(): void
    {
        $file = $this->directory . '/vendor/twitch/fr/errors.php';
        mkdir(
            dirname($file),
            0o777,
            true,
        );
        file_put_contents($file, "<?php return ['mine' => 'x'];");

        $this->invoke('twitch:lang', [
            'locales' => [
                'fr',
            ],
        ])->expectsOutputToContain('already published')->assertSuccessful();
        self::assertStringContainsString('mine', (string) file_get_contents($file));

        $this->invoke('twitch:lang', [
            'locales' => [
                'fr',
            ],
            '--force' => true,
        ])->assertSuccessful();
        self::assertStringNotContainsString('mine', (string) file_get_contents($file));
    }

    #[Test]
    public function it_lists_and_publishes_all_the_languages(): void
    {
        $this->invoke('twitch:lang', [
            '--list' => true,
        ])->expectsOutputToContain('zh_TW')->assertSuccessful();

        $this->invoke('twitch:lang', [
            '--all' => true,
        ])->assertSuccessful();

        self::assertCount(129, (array) glob($this->directory . '/vendor/twitch/*', GLOB_ONLYDIR));
    }

    #[Test]
    public function it_publishes_only_the_languages_asked_for(): void
    {
        $this->invoke('twitch:lang', [
            'locales' => [
                'fr',
                'pt_BR',
            ],
        ])->expectsOutputToContain('fr: published.')->assertSuccessful();

        self::assertFileExists($this->directory . '/vendor/twitch/fr/errors.php');
        self::assertFileExists($this->directory . '/vendor/twitch/pt_BR/errors.php');
        self::assertFileDoesNotExist($this->directory . '/vendor/twitch/de/errors.php');
    }

    #[Test]
    public function it_refuses_an_unknown_language_and_a_path(): void
    {
        $this->invoke('twitch:lang', [
            'locales' => [
                'xx',
            ],
        ])->expectsOutputToContain('Unknown language')->assertFailed();

        $this->invoke('twitch:lang', [
            'locales' => [
                '../../etc',
            ],
        ])->expectsOutputToContain('Unknown language')->assertFailed();

        self::assertDirectoryDoesNotExist($this->directory . '/vendor');
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function invoke(string $command, array $parameters = []): PendingCommand
    {
        $pending = $this->artisan($command, $parameters);
        self::assertInstanceOf(PendingCommand::class, $pending);

        return $pending;
    }
}
