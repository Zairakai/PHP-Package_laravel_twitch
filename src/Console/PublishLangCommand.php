<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Copies the translations of the errors of the package into the application, for the languages asked for only.
 *
 * The package loads all its languages by itself: this is only to change a text. `php artisan twitch:lang fr de`.
 */
final class PublishLangCommand extends Command
{
    protected $description = 'Publish the translations of the Twitch errors for the languages asked for';

    protected $signature = 'twitch:lang
        {locales?* : The languages to publish (fr, de, pt_BR...)}
        {--all : Publish every language}
        {--list : List the languages of the package}
        {--force : Replace the files that already exist}';

    public function handle(Filesystem $files): int
    {
        $available = $this->available($files);

        if ((bool) $this->option('list')) {
            $this->line(implode(', ', $available));

            return self::SUCCESS;
        }

        $asked  = $this->asked($available);
        $failed = $this->refusal($asked, $available);

        if (null !== $failed) {
            $this->error($failed);

            return self::FAILURE;
        }

        foreach ($asked as $locale) {
            $this->publish($files, $locale);
        }

        return self::SUCCESS;
    }

    /**
     * @param list<string> $available
     *
     * @return list<string>
     */
    private function asked(array $available): array
    {
        return (bool) $this->option('all')
            ? $available
            : $this->requested();
    }

    /**
     * @return list<string>
     */
    private function available(Filesystem $files): array
    {
        $names = [];

        foreach ($files->directories(__DIR__ . '/../../lang') as $directory) {
            $names[] = basename(is_string($directory) ? $directory : '');
        }

        sort($names);

        return $names;
    }

    private function publish(Filesystem $files, string $locale): void
    {
        $target = lang_path('vendor/twitch/' . $locale . '/errors.php');

        if (
            $files->exists($target)
            && ! (bool) $this->option('force')
        ) {
            $this->warn("{$locale}: already published (--force replaces it).");

            return;
        }

        $files->ensureDirectoryExists(dirname($target));
        $files->copy(__DIR__ . '/../../lang/' . $locale . '/errors.php', $target);
        $this->info("{$locale}: published.");
    }

    /**
     * The reason why the request cannot be served, null when it can.
     *
     * @param list<string> $asked
     * @param list<string> $available
     */
    private function refusal(array $asked, array $available): ?string
    {
        if ([] === $asked) {
            return 'Give the languages to publish (twitch:lang fr de), or --all. --list shows them.';
        }

        $unknown = array_values(array_diff($asked, $available));

        return [] === $unknown
            ? null
            : 'Unknown language(s): ' . implode(', ', $unknown) . '. --list shows the ones of the package.';
    }

    /**
     * @return list<string>
     */
    private function requested(): array
    {
        $locales = [];

        foreach ((array) $this->argument('locales') as $locale) {
            if (is_string($locale)) {
                $locales[] = $locale;
            }
        }

        return $locales;
    }
}
