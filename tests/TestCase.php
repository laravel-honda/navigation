<?php

namespace Honda\Navigation\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Honda\Navigation\NavigationServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            NavigationServiceProvider::class,
        ];
    }
}
