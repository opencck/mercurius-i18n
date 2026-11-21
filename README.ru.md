[English](README.md) | **Русский** | [中文](README.cn.md)

# mercurius-i18n

Тексты агента [Меркурий](https://github.com/opencck/mercurius) на русском (по умолчанию), английском и китайском за небольшим
интерфейсом `Translator`. Всё, что агент пишет сам, — ответы команд, карточки подтверждений, статусы запуска,
описания и результаты инструментов, системный промпт — хранится здесь, поэтому язык агента — одна настройка.

## Установка

```bash
composer require opencck/mercurius-i18n
```

PHP 8.2+, `ext-mbstring`. Других зависимостей нет.

## Использование

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

| Часть | Что делает |
|-------|------------|
| `Translator` | `t(key, params)`, `plural(key, count, params)`, `language()`, `languages()` |
| `CatalogTranslator` | по плоским каталогам `язык → ключ → текст`; первый каталог — язык по умолчанию. Недостающий текст берётся из языка по умолчанию, затем возвращается сам ключ |
| `Catalogs` | встроенные `lang/ru.php`, `lang/en.php` и `lang/zh.php` (упрощённое письмо; перевод сделан моделью и человеком ещё не проверен); `shape()` — ключи и их подстановки для проверки совпадения |
| `Plural` | форма числа для целого: в русском `one`, `few`, `many`; в китайском одна `other`; в английском и других — `one`, `other` |
| `Lang`, `t()`, `tp()` | переводчик процесса; русский по встроенным каталогам, пока не задан другой |

## Каталоги

- Ключ — `область.имя` (`chat.greeting`, `tool.spending.description`); подстановки именованные: `{name}`.
- Тексты с числом — `ключ.one`, `ключ.few`, `ключ.many` в русском, `ключ.one`, `ключ.other` в английском и `ключ.other` в китайском;
  `{count}` подставляется сам.
- У всех языков одинаковые ключи и одинаковые подстановки, а у каждого ключа с числом — все формы своего языка:
  иначе `composer check` не проходит.

## Проверка

```bash
composer check   # PHPUnit, PHPStan (max), Psalm (уровень 1)
```

## Лицензия

MIT
