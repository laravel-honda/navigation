<?php

namespace Honda\Navigation;

use Honda\UrlPatternMatcher\UrlPatternMatcher;
use Honda\UrlResolver\UrlResolver;

class Item
{
    public string $name;
    public ?string $description;
    public ?string $href = null;
    public ?string $icon;
    public ?string $pattern = null;
    public string $iconSet = 'tabler';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function href(?string $href): self
    {
        $this->href = UrlResolver::guess($href);

        return $this;
    }

    public function icon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function description(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function iconSet(string $iconSet): self
    {
        $this->iconSet = $iconSet;

        return $this;
    }

    public function isActive(): bool
    {
        $matcher = new UrlPatternMatcher($this->pattern);

        return $this->pattern !== null ? $matcher->match(request()->path()) : false;
    }

    public function activePattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }
}
