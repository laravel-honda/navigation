<?php

use Honda\Navigation\Navigation;

if (!function_exists('navigation')) {
    function navigation(string $name): ?Navigation
    {
        return Navigation::$macros[$name] ?? null;
    }
}
