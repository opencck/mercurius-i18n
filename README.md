**English** | [Русский](README.ru.md)

# mercurius-i18n

Texts of the [Mercurius](https://github.com/opencck/mercurius) agent in Russian (the default) and English, behind a
small `Translator` interface. Everything the agent writes by itself — command replies, approval cards, run statuses,
tool descriptions and results, the system prompt — lives here, so the agent's language is one setting.

## Install

```bash
composer require opencck/mercurius-i18n
```

PHP 8.2+, `ext-mbstring`. No other dependencies.

## Use

```php
use Mercurius\I18n\CatalogTranslator;
use Mercurius\I18n\Catalogs;
use Mercurius\I18n\Lang;

use function Mercurius\I18n\t;
use function Mercurius\I18n\tp;

Lang::use(new CatalogTranslator('en', Catalogs::bundled()));

echo t('chat.nothing_to_stop');            // Nothing is running right now.
echo tp('run.model_calls', 3);             // 3 model calls
```

| Piece | What it does |
|-------|--------------|
| `Translator` | `t(key, params)`, `plural(key, count, params)`, `language()`, `languages()` |
| `CatalogTranslator` | over flat catalogs `language → key → text`; the first catalog is the default language. A missing text comes from the default language, then the key itself is returned |
| `Catalogs` | the bundled `lang/ru.php` and `lang/en.php`; `shape()` lists keys with their placeholders for parity checks |
| `Plural` | plural form of an integer: Russian `one`, `few`, `many`; English and others `one`, `other` |
| `Lang`, `t()`, `tp()` | the translator of the process; Russian over the bundled catalogs until another is set |

## Catalogs

- A key is `area.name` (`chat.greeting`, `tool.spending.description`); placeholders are named: `{name}`.
- Plural texts are `key.one`, `key.few`, `key.many` in Russian and `key.one`, `key.other` in English; `{count}` is
  filled in.
- Every language has the same keys and the same placeholders, and every plural key has all forms of its language:
  `composer check` fails otherwise.

## Check

```bash
composer check   # PHPUnit, PHPStan (max), Psalm (level 1)
```

## License

MIT
