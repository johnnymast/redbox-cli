<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli;

use Redbox\Cli\Router\Attributes\Route;
use Redbox\Cli\Output\Line;
use Redbox\Cli\Router\Router;

/**
 * @internal
 */
class Terminal
{

    /**
     * @param \Redbox\Cli\Cli         $cli  The cli class instance.
     * @param \Redbox\Cli\Output\Line $line The line to write.
     *
     * @return void
     */
    #[Route('write')]
    public function write(Cli $cli, Line $line)
    {
        echo "{$line}";
    }
}