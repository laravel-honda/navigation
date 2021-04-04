<?php

namespace Honda\Navigation\Concerns;

use ArrayIterator;
use Honda\Navigation\Item;

trait WithNavigationTree
{
    public array $tree = [];

    public function __invoke(): array
    {
        return $this->tree();
    }

    public function tree(): array
    {
        $built = [];

        foreach ($this->tree as $branch) {
            [$element, $builder] = $branch;

            $built[] = $builder($element);
        }

        return $built;
    }

    /**
     * @param bool|callable $condition
     *
     * @return $this
     */
    public function addIf($condition, string $name, ?callable $builder = null): self
    {
        if (value($condition)) {
            $this->add($name, $builder);
        }

        return $this;
    }

    public function add(string $name, ?callable $builder = null): self
    {
        $builder ??= fn ($item) => $item;

        $this->tree[] = [new Item($name), $builder];

        return $this;
    }

    /**
     * @param bool|callable $condition
     *
     * @return $this
     */
    public function addUnless($condition, string $name, ?callable $builder = null): self
    {
        if (!value($condition)) {
            $this->add($name, $builder);
        }

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tree());
    }
}
