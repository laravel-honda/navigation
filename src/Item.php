<?php


namespace Honda\Navigation;


use Illuminate\Support\Fluent;

class Item extends Fluent
{
    public function __construct(string $name)
    {
        parent::__construct([
            'name' => $name
        ]);
    }
}
