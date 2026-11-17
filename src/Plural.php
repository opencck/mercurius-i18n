<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * The plural form of a number in a language, by the CLDR rules for integers: Russian has one (1, 21, 101…), few
 * (2–4, 22–24…) and many (0, 5–20, 25…); English and the rest — one (1) and other.
 */
final class Plural
{
    public static function form(string $language, int $count): string
    {
        $n = abs($count);
        if ($language === 'ru' || $language === 'uk') {
            $last = $n % 10;
            $lastTwo = $n % 100;
            if ($last === 1 && $lastTwo !== 11) {
                return 'one';
            }
            if ($last >= 2 && $last <= 4 && ($lastTwo < 12 || $lastTwo > 14)) {
                return 'few';
            }

            return 'many';
        }

        return $n === 1 ? 'one' : 'other';
    }

    /** @return list<string> the forms a language has, for checking catalogs */
    public static function forms(string $language): array
    {
        return $language === 'ru' || $language === 'uk' ? ['one', 'few', 'many'] : ['one', 'other'];
    }
}
