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

### Creating a navigation bar

```php
use Honda\Navigation\Navigation;

Navigation::macro('theName', function (Navigation $navigation) {
    // ...
});
```

### Rendering a navigation bar

```php
use Honda\Navigation\Navigation;

Navigation::theName();
```

### Items

#### Href

If you pass a route name like `login` or `articles.index`, the actual path will be resolved. You may pass additional
context to the route resolver.

If you pass anything else, it will be rendered as-is.

```php
$item->href('articles.index');
```

```php
$item->href('articles.edit', ['article' => 1]);
```

```php
$item->href('https://repo.new');
```

#### Icon

This package integrates seamlessly with [Blade Icons](https://github.com).

```php
$item->icon('heroicon-eye');
```

#### Force active state

This will bypass a potentially defined active pattern and force the item to be rendered as an active one.

```php
$item->alwaysActive();
```

#### Active pattern

Mark an item as active based on an advanced pattern. The resolved route path is used if no active pattern is provided.
Check out [URL Pattern Matcher](https://github.com/laravel-honda/url-pattern-matcher) for more details.

```php
$item->activePattern('/articles/*');
```

#### Conditionally rendered items

```php
use Honda\Navigation\Item;

$navigation->addIf($isAdmin, 'Settings', function (Item $item) {
    // ...
});
$navigation->addUnless($isReader, 'Articles', function (Item $item) {
    // ...
});
```

### Section

#### Add a section

```php
use Honda\Navigation\Item;
use Honda\Navigation\Section;

$navigation->addSection('Name', function (Section $section) {
    $section->add('Child', function (Item $item) {
        // ...
    });
});
```

#### Conditionally rendered sections

```php
use Honda\Navigation\Section;

$navigation->addSectionIf($isAdmin, 'Admin', function (Section $section) {
    // ...
});
$navigation->addSectionUnless($isReader, 'Bookmarks', function (Section $section) {
    // ...
});
```

### Blade Components

> We provide a component called `<x-navigation-sidebar />`, feel free to use it as-is (needs AlpineJS to be fully functional).

```php
// app/View/Components/Topbar.php
use Honda\Navigation\Components\Component;
class Topbar extends Component {
    public function viewName() : string{
         return 'components.topbar';
    }
}
```

You get access to an `$items` variables that contains a `Navigation` object.

Now in your views :

```html

<x-topbar :items="\Honda\Navigation\Navigation::myName()"/>
```

## Testing

```bash
composer test
```

**Navigation for Laravel** was created by **[Félix Dorn](https://twitter.com/afelixdorn)** under
the **[MIT license](https://opensource.org/licenses/MIT)**.
