# Navigation for Laravel

[![Tests](https://github.com/laravel-honda/navigation/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/laravel-honda/navigation/actions/workflows/tests.yml)
[![Formats](https://github.com/laravel-honda/navigation/actions/workflows/formats.yml/badge.svg?branch=master)](https://github.com/laravel-honda/navigation/actions/workflows/formats.yml)
[![Version](https://poser.pugx.org/honda/navigation/version)](//packagist.org/packages/honda/navigation)
[![Total Downloads](https://poser.pugx.org/honda/navigation/downloads)](//packagist.org/packages/honda/navigation)
[![License](https://poser.pugx.org/honda/navigation/license)](//packagist.org/packages/honda/navigation)

## Installation

> Requires [PHP 8.0.0+](https://php.net/releases)

You can install the package via composer:

```bash
composer require honda/navigation
```

## Usage

```php
// AppServiceProvider.php
use Honda\Navigation\Item;
use Honda\Navigation\Navigation;
use Honda\Navigation\Section;

Navigation::macro('dashboard', function (Navigation $navigation) {
    $navigation->add('Posts', function (Item $item) {
        $item
            ->href('posts.index')
            ->activePattern('^/posts')
            ->icon('article')
            ->iconSet('heroicon');
        // ...
    })->addSectionIf($user->isAdmin(), "Section's name", function (Section $section) {
        $section->addIf($user->isSuperAdmin(), 'Site Settings',  function () { /* ... */ });
        // ...
    }); 
});
```

```html
// resources/views/layouts/app.blade.php
<x-my-navigation-component :items="Navigation::dashboard()"/>
```

### Registering navigations bars

## Testing

```bash
composer test
```

**Navigation for Laravel** was created by **[Félix Dorn](https://twitter.com/afelixdorn)** under
the **[MIT license](https://opensource.org/licenses/MIT)**.
