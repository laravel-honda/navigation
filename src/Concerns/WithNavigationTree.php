<?php

namespace Honda\Navigation\Concerns;

use ArrayIterator;
use Honda\Navigation\Item;
use RuntimeException;

trait WithNavigationTree
{
    protected array $tree = [];

    public function __invoke(): array
    {
        return $this->tree();
    }

    public function tree(): array
    {
        $built = [];

        foreach ($this->tree as $branch) {
            [$element, $builder] = $branch;

            $builtElement = $builder($element);
            if (!$builtElement) {
                $builtElement = $element;
            }

            $built[] = $builtElement;
        }

        return $built;
    }

    public function addIf(callable|bool $condition, string $name, ?callable $builder = null): self
    {
        if (value($condition)) {
            $this->add($name, $builder);
        }

        return $this;
    }

    public function add(string $name, ?callable $builder = null): self
    {
        $builder ??= static fn($item) => $item;

        $this->tree[] = [new Item($name), $builder];

        return $this;
    }

    public function addUnless(callable|bool $condition, string $name, ?callable $builder = null): self
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

    public function count(): int
    {
        return count($this->tree());
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->tree()[$offset];
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->tree());
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new RuntimeException('You can not set an item in the navigation tree');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new RuntimeException('You can not unset an item in the navigation tree');
    }
}
