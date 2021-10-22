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

/**
 * Class Redbox\Cli\Arguments\Operation
 */
class Operation
{

    /**
     * A list of options within this operation.
     *
     * @var array<string, \Redbox\Cli\Arguments\Option>
     */
    protected array $options = [];

    public function __construct(public string $name, array ...$parameter)
    {
    }

    /**
     * Add a new option to this operation.
     *
     * @param string      $name        The name of this option.
     * @param string|null $prefix      The short prefix for this option.
     * @param int|null    $options     The Options for this option.
     * @param string      $description The description for this option.
     * @param string|null $default     The default value for this option.
     */
    public function opt(string $name, ?string $prefix, int|null $options, string $description, string $default = null): Operation
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
     * Return the options within this operation.
     *
     * @return \Redbox\Cli\Arguments\Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}