<?php

namespace Honda\Navigation;

use BadMethodCallException;
use Honda\Navigation\Concerns\WithNavigationTree;
use Illuminate\Support\Traits\Macroable;
use IteratorAggregate;

class Navigation implements IteratorAggregate
{
    use WithNavigationTree;
    use Macroable;

    protected array $injectedVariables = [];
    protected array $slots             = [];

    public static function __callStatic(string $name, array $parameters): self
    {
        if (array_key_exists($name, static::$macros)) {
            $navigation = new static();

            call_user_func(static::$macros[$name], $navigation, ...$parameters);

            return $navigation;
        }

        throw new BadMethodCallException(sprintf('[%s] is not registered', $name));
    }

    public function getInjectedVariables(): array
    {
        return $this->injectedVariables;
    }

    public function getSlots(): array
    {
        return $this->slots;
    }

    /**
     * @param bool|callable $condition
     *
     * @return $this
     */
    public function addSectionIf($condition, string $name, callable $builder): self
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

    /**
     * @param bool|callable $condition
     *
     * @return $this
     */
    public function addSectionUnless($condition, string $name, callable $builder): self
    {
        if (!value($condition)) {
            $this->addSection($name, $builder);
        }

        return $this;
    }

    public function inject(string $key, $value): self
    {
        $this->injectedVariables[$key] = $value;

        return $this;
    }

    /**
     * @param string|callable|mixed $value
     *
     * @return $this
     */
    public function slot(string $name, $value): self
    {
        $this->slots[$name] = value($value);

        return $this;
    }
}
