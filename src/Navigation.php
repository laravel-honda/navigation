<?php

namespace Honda\Navigation;

use BadMethodCallException;
use IteratorAggregate;

class Navigation implements IteratorAggregate
{
    use WithNavigationTree;
    public static array $macros = [];

    public static function register(string $name, callable $builder): void
    {
        static::$macros[$name] = $builder;
    }

    public static function __callStatic($name, $arguments)
    {
        if (array_key_exists($name, static::$macros)) {
            return call_user_func(static::$macros[$name], new static(), ...$arguments);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', static::class, $name));
    }
}
