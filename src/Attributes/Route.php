<?php

namespace Redbox\Cli\Attributes;

use Attribute;

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