<?php

namespace Honda\Navigation;

use ArrayIterator;
use BadMethodCallException;
use InvalidArgumentException;
use IteratorAggregate;

class Navigation implements IteratorAggregate
{
    public static array $macros = [];
    public array $tree          = [];
    public ?string $name;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

    public static function register(string $name, $builder): void
    {
        if (!is_callable($builder) && !$builder instanceof self) {
            throw new InvalidArgumentException(sprintf('Builder must be either an instance or a callable returning %s ', static::class));
        }

        static::$macros[$name] = $builder;
    }

    public static function __callStatic($name, $arguments)
    {
        if (array_key_exists($name, static::$macros)) {
            return call_user_func(static::$macros[$name], static::create(), ...$arguments);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', static::class, $name));
    }

    public static function create(): self
    {
        return new static();
    }

    public function __invoke()
    {
        return $this->tree();
    }

    public function tree(): array
    {
        $built = [];

        foreach ($this->tree as $branch) {
            if (is_callable($branch)) {
                $built[] = $branch(new static());
                continue;
            }

            [$dto, $builder] = $branch;

            $built[] = $builder($dto);
        }

        return $built;
    }

    public function isActive(): bool
    {
        if ($this->name === null) {
            return false;
        }

        foreach ($this->tree() as $item) {
            if ($item->isActive()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string|callable|null $name
     *
     * @return $this
     */
    public function section($name = null, ?callable $builder = null): self
    {
        $this->tree[] = [new static($name), $builder];

        return $this;
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

    public function getIterator()
    {
        return new ArrayIterator($this->tree());
    }
}
