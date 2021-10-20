<?php

namespace Redbox\Cli\Attributes;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class ColorRoute extends BaseAttribute
{
    public const COLOR_TYPE_FOREGROUND = 0;
    public const COLOR_TYPE_BACKGROUND = 1;

    /**
     * @param string $method The name of the method
     */
    public function __construct(protected string $method, protected int $type)
    {
    }

    public function getType(): int
    {
        return $this->type;
    }
}