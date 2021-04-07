<?php

namespace Honda\Navigation\Components;

use Honda\Navigation\Navigation;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component as BladeComponent;

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
            foreach ($this->items->slots as $name => $html) {
                $componentData[$name] = new HtmlString((string) $html);
            }

            return (string) view($this->viewName(), $componentData);
        };
    }

    abstract public function viewName(): string;
}
