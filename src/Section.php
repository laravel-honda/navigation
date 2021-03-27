<?php

namespace Honda\Navigation;

use IteratorAggregate;

class Section implements IteratorAggregate
{
    use WithNavigationTree;

    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
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
