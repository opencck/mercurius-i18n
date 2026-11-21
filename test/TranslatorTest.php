<?php

declare(strict_types=1);

namespace Mercurius\I18n\Test;

use Mercurius\I18n\CatalogTranslator;
use Mercurius\I18n\Lang;
use PHPUnit\Framework\TestCase;

use function Mercurius\I18n\t;
use function Mercurius\I18n\tp;

final class TranslatorTest extends TestCase
{
    /** @var array<string, array<string, string>> */
    private const CATALOGS = [
        'ru' => [
            'chat.hello' => 'Привет, {name}!',
            'chat.only_ru' => 'Только по-русски',
            'run.calls.one' => '{count} вызов',
            'run.calls.few' => '{count} вызова',
            'run.calls.many' => '{count} вызовов',
        ],
        'en' => [
            'chat.hello' => 'Hello, {name}!',
            'run.calls.one' => '{count} call',
            'run.calls.other' => '{count} calls',
        ],
        'zh' => [
            'run.calls.other' => '{count} 次调用',
        ],
    ];

    protected function tearDown(): void
    {
        Lang::reset();
        parent::tearDown();
    }

    public function testATextIsTakenInTheLanguageWithItsPlaceholders(): void
    {
        $en = new CatalogTranslator('en', self::CATALOGS);

        self::assertSame('Hello, Ann!', $en->t('chat.hello', ['name' => 'Ann']));
        self::assertSame('Hello, {name}!', $en->t('chat.hello'), 'a missing value leaves the placeholder');
        self::assertSame('Только по-русски', $en->t('chat.only_ru'), 'a missing text falls back to the default language');
        self::assertSame('no.such.key', $en->t('no.such.key'), 'then to the key itself');
        self::assertSame('en', $en->language());
        self::assertSame(['ru', 'en', 'zh'], $en->languages());
    }

    public function testAnUnknownLanguageIsTheDefaultOne(): void
    {
        $translator = new CatalogTranslator('de', self::CATALOGS);

        self::assertSame('ru', $translator->language());
        self::assertSame('Привет, Ann!', $translator->t('chat.hello', ['name' => 'Ann']));
    }

    public function testPluralFormsFollowTheLanguage(): void
    {
        $ru = new CatalogTranslator('ru', self::CATALOGS);
        $en = new CatalogTranslator('en', self::CATALOGS);

        self::assertSame(
            ['1 вызов', '2 вызова', '5 вызовов', '11 вызовов', '21 вызов', '104 вызова', '0 вызовов'],
            array_map(static fn(int $n): string => $ru->plural('run.calls', $n), [1, 2, 5, 11, 21, 104, 0]),
        );
        self::assertSame(['1 call', '2 calls', '0 calls'], array_map(static fn(int $n): string => $en->plural('run.calls', $n), [1, 2, 0]));
        $zh = new CatalogTranslator('zh', self::CATALOGS);
        self::assertSame(['1 次调用', '5 次调用'], array_map(static fn(int $n): string => $zh->plural('run.calls', $n), [1, 5]), 'Chinese has one form');
    }

    public function testTheProcessTranslatorIsRussianUntilAnotherIsSet(): void
    {
        self::assertSame('ru', Lang::current()->language());

        Lang::use(new CatalogTranslator('en', self::CATALOGS));

        self::assertSame('Hello, Ann!', t('chat.hello', ['name' => 'Ann']));
        self::assertSame('3 calls', tp('run.calls', 3));
    }
}
