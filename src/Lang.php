<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * The translator of the process. Texts are needed in hundreds of places, so they are reached through t() rather than
 * passed into every constructor (as hermes does with its t()). Until another is set it is Russian over the bundled
 * catalogs; the application sets the configured language at start.
 */
final class Lang
{
    private static ?Translator $current = null;

    public static function use(Translator $translator): void
    {
        self::$current = $translator;
    }

    public static function current(): Translator
    {
        return self::$current ??= new CatalogTranslator('ru', Catalogs::bundled());
    }

    /** Back to the bundled Russian: for tests. */
    public static function reset(): void
    {
        self::$current = null;
    }
}
