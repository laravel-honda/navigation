<?php


namespace Honda\Navigation\Components;


use Honda\Navigation\Navigation;
use Illuminate\View\Component;

class Topbar extends Component
{
    public Navigation $items;

    public function __construct(Navigation $items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('navigation::topbar');
    }
}
