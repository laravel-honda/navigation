<?php

namespace Honda\Navigation;


use Honda\UrlResolver\UrlResolver;
use Illuminate\Support\Traits\Macroable;

class Navigation
{
    public array $tree = [];

    use Macroable;

    public static function create(): self
    {
        return new static;
    }

    public function section(callable $builder): self
    {
        $this->tree[] = $builder;
        return $this;
    }

    public function add(string $name, callable $builder): self
    {
        $this->tree[] = [$name, $builder];
        return $this;
    }

    public function tree(): array
    {
        $built = [];

        foreach ($this->tree as $branch) {
            if (is_callable($branch)) {
                $built[] = $branch(new static);
                continue;
            }

            [$name, $builder] = $branch;
            $built[] = $builder(new Item($name));
        }

        return $built;
    }
}
