<?php

namespace Honda\Navigation;

use Honda\Navigation\Concerns\WithNavigationTree;
use IteratorAggregate;

class Section implements IteratorAggregate
{
    use WithNavigationTree;

    public function __construct(public string $name)
    {
    }

    public function isActive(): bool
    {
        foreach ($this->tree() as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }
}
