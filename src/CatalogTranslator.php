<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * A translator over flat catalogs "language → key → text". The first catalog is the default language: an unknown
 * language is the default one, and a text missing in the language comes from it.
 *
 * ref: references/hermes-agent/agent/i18n.py@e96221fa:L169-L190 (t) — the language, then the default one, then the key;
 *      a placeholder without a value stays as it is. hermes defaults to English; here the default is the first catalog.
 */
final class CatalogTranslator implements Translator
{
    private readonly string $language;
    private readonly string $default;

    /**
     * @param array<string, array<string, string>> $catalogs the default language first
     */
    public function __construct(string $language, private readonly array $catalogs)
    {
        $languages = array_keys($catalogs);
        if ($languages === []) {
            throw new \InvalidArgumentException('No catalogs');
        }
        $this->default = $languages[0];
        $language = strtolower(trim($language));
        $this->language = isset($catalogs[$language]) ? $language : $this->default;
    }

    public function t(string $key, array $params = []): string
    {
        $text = $this->catalogs[$this->language][$key] ?? $this->catalogs[$this->default][$key] ?? $key;

        return self::fill($text, $params);
    }

    public function plural(string $key, int $count, array $params = []): string
    {
        $form = $key . '.' . Plural::form($this->language, $count);
        if (!isset($this->catalogs[$this->language][$form])) {
            $form = $key . '.' . Plural::form($this->default, $count);
        }

        return $this->t($form, ['count' => $count] + $params);
    }

    public function language(): string
    {
        return $this->language;
    }

    public function languages(): array
    {
        return array_keys($this->catalogs);
    }

    /**
     * @param array<string, string|int|float> $params
     */
    private static function fill(string $text, array $params): string
    {
        if ($params === [] || !str_contains($text, '{')) {
            return $text;
        }
        $pairs = [];
        foreach ($params as $name => $value) {
            $pairs['{' . $name . '}'] = (string) $value;
        }

        return strtr($text, $pairs);
    }
}
