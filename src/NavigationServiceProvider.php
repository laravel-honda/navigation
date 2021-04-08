<?php

namespace Honda\Navigation;

use Carbon\Laravel\ServiceProvider;
use Honda\Navigation\Components\Sidebar;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../resources/views/' => resource_path('views/vendor/navigation'),
            ], 'navigation-views');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'navigation');
        $this->loadViewComponentsAs('navigation', [
            Sidebar::class,
        ]);
    }
}
