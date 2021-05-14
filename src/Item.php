<?php

namespace Honda\Navigation;

use Honda\UrlPatternMatcher\UrlPatternMatcher;
use Honda\UrlResolver\UrlResolver;

/**
 * @property string $iconSet
 */
class Item
{
    public static string $defaultIconSet = 'tabler';
    public string $name;
    public ?string $href      = null;
    public ?string $icon      = null;
    public ?string $pattern   = null;
    public bool $alwaysActive = false;
    private string $_iconSet  = '';

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
        $this->_iconSet = $iconSet;

        return $this;
    }

    /**
     * @see https://wiki.php.net/rfc/property_accessors
     */
    public function __get(string $name): ?string
    {
        if ($name !== 'iconSet') {
            trigger_error('Undefined property: Item::' . $name, E_USER_WARNING);

            return null;
        }

        if (!empty($this->_iconSet)) {
            return $this->_iconSet;
        }

        return static::$defaultIconSet;
    }

    public function isActive(): bool
    {
        if ($this->alwaysActive) {
            return true;
        }

        if (empty($this->pattern) && empty($this->href)) {
            return false;
        }

        $matcher = new UrlPatternMatcher($this->pattern ?? $this->href ?? '');

        return $this->pattern !== null && $matcher->match(app('request')->path());
    }

    public function activePattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }
}
