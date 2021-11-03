<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Router\Attributes;

use Attribute;
use JetBrains\PhpStorm\Pure;
use Redbox\Cli\Router\Attributes\BaseAttribute;

/**
 * @internal
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class ColorRoute extends BaseAttribute
{
    /**
     * Using this flag makes this color route
     * usable for foregrounds.
     *
     * @exanple red becomes red().
     */
    public const COLOR_TYPE_FOREGROUND = 0;

    /**
     * Using this flag makes this color route
     * usable for backgrounds.
     *
     * @exanple red becomes backgroundColorRed().
     */
    public const COLOR_TYPE_BACKGROUND = 1;

    /**
     * ColorRoute constructor.
     *
     * @param string $method The name of the method.
     * @param int    $type   The color type flag.
     */
    #[Pure] public function __construct(protected string $method, protected int $type)
    {
        parent::__construct($this->method);
    }

    /**
     * Return te Route Color Type.
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}