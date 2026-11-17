<?php

declare(strict_types=1);

namespace Mercurius\I18n;

/**
 * A text of the process translator.
 *
 * @param array<string, string|int|float> $params
 */
function t(string $key, array $params = []): string
{
    return Lang::current()->t($key, $params);
}

/**
 * The form of a text for a number; {count} is filled in.
 *
 * @param array<string, string|int|float> $params
 */
function tp(string $key, int $count, array $params = []): string
{
    return Lang::current()->plural($key, $count, $params);
}
