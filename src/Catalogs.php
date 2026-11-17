<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * The bundled catalogs (lang/<language>.php, each returning a flat array "key → text") and their shape for checks.
 */
final class Catalogs
{
    /** The default language first. */
    public const LANGUAGES = ['ru', 'en'];

    /** @var array<string, array<string, string>>|null */
    private static ?array $bundled = null;

    /** @return array<string, array<string, string>> */
    public static function bundled(): array
    {
        if (self::$bundled !== null) {
            return self::$bundled;
        }
        $catalogs = [];
        foreach (self::LANGUAGES as $language) {
            $catalogs[$language] = self::load(dirname(__DIR__) . '/lang/' . $language . '.php');
        }

        return self::$bundled = $catalogs;
    }

    /**
     * Keys with their placeholders; the plural forms of a key ("x.one", "x.few"…) count as the key "x".
     *
     * @param array<string, string> $catalog
     * @return array<string, list<string>> sorted by key, placeholders sorted
     */
    public static function shape(array $catalog): array
    {
        $shape = [];
        foreach ($catalog as $key => $text) {
            $base = preg_replace('/\.(one|few|many|other)$/', '', $key) ?? $key;
            preg_match_all('/\{([a-z_][a-z0-9_]*)\}/i', $text, $m);
            $names = array_values(array_unique([...($shape[$base] ?? []), ...$m[1]]));
            sort($names);
            $shape[$base] = $names;
        }
        ksort($shape);

        return $shape;
    }

    /** @return array<string, string> */
    private static function load(string $path): array
    {
        /** @var mixed $catalog */
        $catalog = is_file($path) ? require $path : [];
        $texts = [];
        if (is_array($catalog)) {
            /** @var mixed $text */
            foreach ($catalog as $key => $text) {
                if (is_string($key) && is_string($text)) {
                    $texts[$key] = $text;
                }
            }
        }

        return $texts;
    }
}
