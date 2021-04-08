<?php

use Honda\Navigation\Components\Sidebar;

it('sets the items as a public property', function () {
    $navigation = new Honda\Navigation\Navigation();
    $component = new Sidebar($navigation);
    expect($component->items)->toBe($navigation);
});

// TODO: We need real tests here lol
