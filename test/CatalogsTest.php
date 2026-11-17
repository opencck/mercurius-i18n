<?php

declare(strict_types=1);

namespace Mercurius\I18n\Test;

use Mercurius\I18n\Catalogs;
use Mercurius\I18n\Plural;
use PHPUnit\Framework\TestCase;

/**
 * Every language has the same texts with the same placeholders; plural forms count as one text.
 */
final class CatalogsTest extends TestCase
{
    public function testTheBundledLanguagesAreRussianAndEnglish(): void
    {
        self::assertSame(['ru', 'en'], array_keys(Catalogs::bundled()));
    }

    public function testEveryLanguageHasTheSameKeysAndPlaceholders(): void
    {
        $catalogs = Catalogs::bundled();
        $ru = Catalogs::shape($catalogs['ru']);
        foreach ($catalogs as $language => $catalog) {
            $shape = Catalogs::shape($catalog);
            self::assertSame([], array_keys(array_diff_key($ru, $shape)), "missing in {$language}");
            self::assertSame([], array_keys(array_diff_key($shape, $ru)), "only in {$language}");
            foreach ($ru as $key => $placeholders) {
                self::assertSame($placeholders, $shape[$key] ?? null, "placeholders of {$key} in {$language}");
            }
        }
    }

    public function testEveryPluralKeyHasAllFormsOfItsLanguage(): void
    {
        foreach (Catalogs::bundled() as $language => $catalog) {
            $bases = [];
            foreach (array_keys($catalog) as $key) {
                if (preg_match('/^(.+)\.(one|few|many|other)$/', $key, $m) === 1) {
                    $bases[$m[1]][] = $m[2];
                }
            }
            foreach ($bases as $base => $forms) {
                sort($forms);
                $expected = Plural::forms($language);
                sort($expected);
                self::assertSame($expected, $forms, "forms of {$base} in {$language}");
            }
        }
    }

    public function testShapeJoinsPluralFormsAndListsPlaceholders(): void
    {
        self::assertSame(
            ['a' => ['name'], 'n' => ['count', 'who'], 'p' => ['%s', '%d', '%%']],
            Catalogs::shape(['a' => 'Hi {name}', 'n.one' => '{count} от {who}', 'n.many' => '{count} от {who}', 'p' => 'Запуск %s: %d токенов, 100%%']),
        );
    }
}
