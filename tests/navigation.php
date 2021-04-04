<?php

use Honda\Navigation\Item;
use Honda\Navigation\Navigation;
use Honda\Navigation\Tests\TestCase;

uses(TestCase::class);

it('can add items', function () {
    $navigation = new Navigation();
    $navigation
        ->add('Laravel', fn (Item $item) => $item->href('https://laravel.com'));

    expect($navigation->tree())->toMatchTree([
        Item::new('Laravel')->href('https://laravel.com'),
    ]);
});
it('can add items if a condition is true', function () {
    expect(
        (new Navigation())
            ->addIf(true, 'Home')
            ->tree()
    )->toMatchTree([Item::new('Home')]);

    expect(
        (new Navigation())
            ->addIf(fn () => true, 'Home')
            ->tree()
    )->toMatchTree([Item::new('Home')]);

    expect(
        (new Navigation())
            ->addIf(false, 'Home')
            ->tree()
    )->toBeEmpty();

    expect(
        (new Navigation())
            ->addIf(fn () => false, 'Home')
            ->tree()
    )->toBeEmpty();
});
it('can add items if unless a condition is true', function () {
    expect(
        (new Navigation())
            ->addUnless(true, 'Home')
            ->tree()
    )->toBeEmpty();

    expect(
        (new Navigation())
            ->addUnless(fn () => true, 'Home')
            ->tree()
    )->toBeEmpty();

    expect(
        (new Navigation())
            ->addUnless(false, 'Home')
            ->tree()
    )->toMatchTree([Item::new('Home')]);

    expect(
        (new Navigation())
            ->addUnless(fn () => false, 'Home')
            ->tree()
    )->toMatchTree([Item::new('Home')]);
});
