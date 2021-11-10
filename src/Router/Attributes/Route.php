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
use Redbox\Cli\Router\Attributes\BaseAttribute;

/**
 * @internal
 */
#[Attribute]
class Route extends BaseAttribute
{
    /**
     * @param string $method The name of the method
     */
    public function __construct(string $method)
    {
        parent::__construct($method);
    }
}