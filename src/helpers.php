<?php

use Honda\Navigation\Navigation;

if (!function_exists('navigation')) {
    function navigation(string $name)
    {
        return Navigation::$macros[$name];
    }
}
