<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * Texts in the current language. A key is a dotted name ("chat.greeting"); a text holds named placeholders
 * ("{name}") filled from the parameters. A text missing in the language comes from the default one, then the key itself
 * is returned, so a gap shows up without breaking anything.
 */
interface Translator
{
    /**
     * @param array<string, string|int|float> $params
     */
    public function t(string $key, array $params = []): string;

    /**
     * The form for a number: "{count} вызов / вызова / вызовов". The catalog holds "<key>.one", "<key>.few",
     * "<key>.many" for Russian and "<key>.one", "<key>.other" for English; {count} is filled in.
     *
     * @param array<string, string|int|float> $params
     */
    public function plural(string $key, int $count, array $params = []): string;

    /** The language in use, e.g. "ru". */
    public function language(): string;

    /** @return list<string> the languages there are catalogs for, the default first */
    public function languages(): array;
}
