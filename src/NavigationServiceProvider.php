<?php

namespace Honda\Navigation;

use Carbon\Laravel\ServiceProvider;
use Honda\Navigation\Components\Sidebar;
use Honda\Navigation\Components\Topbar;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'navigation');
        $this->loadViewComponentsAs('navigation', [
            Topbar::class,
            Sidebar::class,
        ]);

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../../resources/views/' => resource_path('views/vendor/navigation'),
        ], 'navigation-views');
    }
}
