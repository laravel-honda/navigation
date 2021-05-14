<?php

namespace Honda\Navigation;

use BadMethodCallException;
use Honda\Navigation\Concerns\WithNavigationTree;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Traits\Macroable;
use IteratorAggregate;

class Navigation implements IteratorAggregate
{
    use WithNavigationTree;
    use Macroable;

    protected array $injectedVariables = [];
    protected array $slots             = [];

    public static function __callStatic(string $method, array $parameters): self
    {
        if (array_key_exists($method, static::$macros)) {
            $navigation = new static();

            call_user_func(static::$macros[$method], $navigation, ...$parameters);

            return $navigation;
        }

        throw new BadMethodCallException(sprintf('[%s] is not registered', $method));
    }

    public function getInjectedVariables(): array
    {
        return $this->injectedVariables;
    }

    public function getSlots(): array
    {
        return $this->slots;
    }

    public function addSectionIf(bool | callable $condition, string $name, callable $builder): self
    {
        if (value($condition)) {
            $this->addSection($name, $builder);
        }

        return $this;
    }

    public function addSection(string $name, ?callable $builder = null): self
    {
        $this->tree[] = [new Section($name), $builder];

        return $this;
    }

    public function addSectionUnless(bool | callable $condition, string $name, callable $builder): self
    {
        if (!value($condition)) {
            $this->addSection($name, $builder);
        }

        return $this;
    }

    public function inject(string $key, mixed $value): self
    {
        $this->injectedVariables[$key] = $value;

        return $this;
    }

    public function slot(string $name, string | callable | HtmlString $value): self
    {
        $this->slots[$name] = (string) value($value);

        return $this;
    }
}
