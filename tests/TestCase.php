<?php

namespace Honda\Navigation\Tests;

use Honda\Navigation\NavigationServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            NavigationServiceProvider::class,
        ];
    }
}
