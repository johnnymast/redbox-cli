<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Attributes;

use Attribute;

/**
 * @internal
 */
#[Attribute]
class Route extends BaseAttribute
{
    /**
     * The name of the method.
     *
     * @var string
     */
    protected string $method;

    /**
     * @param string $method The name of the method
     */
    public function __construct(string $method)
    {
        $this->method = $method;
    }

    /**
     * Return the method name.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}