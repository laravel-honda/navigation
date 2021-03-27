<?php

namespace Honda\Navigation;

use ArrayIterator;

trait WithNavigationTree
{
    public array $tree = [];

    public function __invoke()
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

    public function add(string $name, callable $builder): self
    {
        $this->tree[] = [new Item($name), $builder];

        return $this;
    }

    public function addIf($condition, string $name, callable $builder): self
    {
        if (value($condition)) {
            $this->tree[] = [new Item($name), $builder];
        }

        return $this;
    }

    public function addUnless($condition, string $name, callable $builder): self
    {
        if (!value($condition)) {
            $this->tree[] = [new Item($name), $builder];
        }

        return $this;
    }

    public function addSectionIf($condition, string $name, callable $builder): self
    {
        if (value($condition)) {
            $this->tree[] = [new Section($name), $builder];
        }

        return $this;
    }

    public function addSectionUnless($condition, string $name, callable $builder): self
    {
        if (!value($condition)) {
            $this->tree[] = [new Section($name), $builder];
        }

        return $this;
    }

    /**
     * @param string|callable|null $name
     * @param callable|null $builder
     * @return $this
     */
    public function section($name, ?callable $builder = null): self
    {
        $this->tree[] = [new Section($name), $builder];

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tree());
    }
}
