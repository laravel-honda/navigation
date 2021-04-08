<?php

namespace Honda\Navigation\Components;

use Honda\Navigation\Navigation;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component as BladeComponent;
use Illuminate\View\Factory;

abstract class Component extends BladeComponent
{
    public Navigation $items;

    public function __construct(Navigation $items)
    {
        $this->items = $items;
    }

    public function render(): callable
    {
        return function ($componentData) {
            collect($this->items->getInjectedVariables())
                ->merge(
                    collect($this->items->getSlots())->mapInto(HtmlString::class)
                )->each(function (string $value, string $key) use (&$componentData) {
                    $componentData[$key] = $value;
                });

            return (string)app(Factory::class)->make($this->viewName(), $componentData);
        };
    }

    abstract public function viewName(): string;
}
