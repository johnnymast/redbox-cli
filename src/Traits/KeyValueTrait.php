<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Traits;

/**
 * @internal
 * @trait Redbox\Cli\traits\KeyValueTrait
 */
trait KeyValueTrait
{
    /**
     * Key/Value container
     *
     * @var array<string, mixed>
     */
    protected array $items = [];

    /**
     * Set the value for a key.
     *
     * @param string $key   The key for the value.
     * @param mixed  $value The value itself.
     */
    public function set(string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * Return the value of the given key.
     *
     * @param string $key The key for the value.
     *
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if ($this->has($key)) {
            return $this->items[$key];
        }

        return false;
    }

    /**
     * Check if key $key has a value.
     *
     * @param string $key The key to check.
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Remove a key/value pair.
     *
     * @param string $key The key to remove the value from.
     *
     * @return bool
     */
    public function remove(string $key): bool
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
            return true;
        }
        return false;
    }
}