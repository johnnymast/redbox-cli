<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Arguments;

use Redbox\Cli\traits\KeyValueTrait;

/**
 * @class Redbox\Cli\Arguments\Operation
 */
class Operation
{
    use KeyValueTrait;

    /**
     * This flag indicates if this is the
     * default operation created by Redbox-Cli
     * internally.
     *
     * @var bool
     */
    public bool $defaultOperation = false;

    /**
     * A list of options within this operation.
     *
     * @var array<string, \Redbox\Cli\Arguments\Option>
     */
    protected array $options = [];

    /**
     * @param string $name    The name.
     * @param mixed  ...$args The arguments.
     */
    public function __construct(public string $name, array ...$args)
    {
    }

    /**
     * Add a new option to this operation.
     *
     * @param string|null $name        The name of this option.
     * @param string|null $prefix      The short prefix for this option.
     * @param int|null    $options     The Options for this option.
     * @param string      $description The description for this option.
     * @param string|null $default     The default value for this option.
     */
    public function opt(string|null $name, ?string $prefix, int|null $options, string $description, string $default = null): Operation
    {
        $option = new Option(
            $this,
            $name,
            $prefix,
            $options,
            $description,
            $default
        );

        $this->options[$name] = $option;

        return $this;
    }

    /**
     * Check if this operation has any options.
     *
     * @return bool
     */
    public function hasOptions(): bool
    {
        return (count($this->options) > 0);
    }

    public function getOptionsWithShortPrefix(): array
    {
        return array_filter($this->options, static fn(Option $option) => $option->hasShortPrefix());
    }

    public function getOptionsWithLongPrefix(): array
    {
        return array_filter($this->options, static fn(Option $option) => $option->hasShortPrefix());
    }

    /**
     * Get all required options in this operation.
     *
     * @return array
     */
    public function getRequiredOptions(): array
    {
        return array_filter($this->options, static fn(Option $option) => $option->isRequired());
    }

    /**
     * Get all optional options in this operation.
     *
     * @return array
     */
    public function getOptionalOptions(): array
    {
        return array_filter($this->options, static fn(Option $option) => $option->isOptional());
    }

    /**
     * Get all options in this operation.
     *
     * @return \Redbox\Cli\Arguments\Option[]
     */
    public function getAllOptions(): array
    {
        return $this->options;
    }

    /**
     * Indicate if this is the default operation.
     * This means it was not created by a user.
     *
     * @return bool
     */
    public function isDefaultOperation(): bool
    {
        return $this->defaultOperation;
    }

    /**
     * Set this operation as default.
     */
    public function markAsDefault(): void
    {
        $this->defaultOperation = true;
    }

    /**
     * Return the options within this operation.
     *
     * @return \Redbox\Cli\Arguments\Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}