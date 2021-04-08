<?php

namespace Honda\Navigation;

use Honda\UrlPatternMatcher\UrlPatternMatcher;
use Honda\UrlResolver\UrlResolver;

class Item
{
    public string $name;
    public ?string $href      = null;
    public ?string $icon      = null;
    public ?string $pattern   = null;
    public string $iconSet    = 'tabler';
    public bool $alwaysActive = false;

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function alwaysActive(): self
    {
        $this->alwaysActive = true;

        return $this;
    }

    public function iconSet(string $iconSet): self
    {
        $this->iconSet = $iconSet;

        return $this;
    }

    public function isActive(): bool
    {
        if ($this->alwaysActive) {
            return true;
        }

        $matcher = new UrlPatternMatcher($this->pattern ?? $this->href);

        return $this->pattern !== null ? $matcher->match(app('request')->path()) : false;
    }

    public function activePattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }
}
