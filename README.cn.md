[English](README.md) | [Русский](README.ru.md) | **中文**

# mercurius-i18n

[Mercurius](https://github.com/opencck/mercurius) 智能体的文本，提供俄语（默认）、英语和中文三种语言，位于一个小巧的 `Translator` 接口之后。智能体自己写出的所有内容——命令回复、审批卡片、运行状态、工具描述和结果、系统提示词——都放在这里，因此智能体的语言只是一项设置。

## 安装

```bash
composer require opencck/mercurius-i18n
```

PHP 8.2+，`ext-mbstring`。无其他依赖。

## 使用

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

| 组件 | 作用 |
|------|------|
| `Translator` | `t(key, params)`、`plural(key, count, params)`、`language()`、`languages()` |
| `CatalogTranslator` | 基于扁平目录 `语言 → 键 → 文本`；第一个目录是默认语言。缺失的文本取自默认语言，仍缺失则返回键本身 |
| `Catalogs` | 内置的 `lang/ru.php`、`lang/en.php` 和 `lang/zh.php`（简体）；`shape()` 列出各键及其占位符，用于一致性检查 |
| `Plural` | 整数的复数形式：俄语为 `one`、`few`、`many`；中文只有 `other`；英语及其他语言为 `one`、`other` |
| `Lang`、`t()`、`tp()` | 进程级的翻译器；在设置其他翻译器之前，使用内置目录的俄语 |

## 目录

- 键的形式为 `area.name`（`chat.greeting`、`tool.spending.description`）；占位符为具名形式：`{name}`。
- 复数文本在俄语中为 `key.one`、`key.few`、`key.many`，在英语中为 `key.one`、`key.other`，在中文中为 `key.other`；`{count}` 会被填入。
- 每种语言的键和占位符都相同，且每个复数键都包含其语言的全部形式：否则 `composer check` 会失败。

## 检查

```bash
composer check   # PHPUnit, PHPStan (max), Psalm (level 1)
```

## 许可证

MIT
