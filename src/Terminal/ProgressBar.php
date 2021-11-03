<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Terminal;

use Redbox\Cli\Router\Attributes\Route;
use Redbox\Cli\Output\OutputBuffer;

/**
 * @internal
 */
class ProgressBar
{
    /**
     * This character will delete the line.
     */
    private const DELETE_CHAR = 13;

    /**
     * Render a progressbar to the screen.
     *
     * @param \Redbox\Cli\Output\OutputBuffer     $outputBuffer The output buffer to write to.
     * @param \Redbox\Cli\Router\Attributes\Route $route        The current route.
     * @param int                                 $at           The current progression.
     * @param int                                 $of           The max percentage.
     *
     * @return void
     */
    #[Route('progress')]
    public function progress(OutputBuffer $outputBuffer, Route $route, int $at = 0, int $of = 0): void
    {
        $bar = str_repeat('#', $at) . str_repeat(".", ($of - $at));

        $outputBuffer->addRawLine(chr(self::DELETE_CHAR));
        $outputBuffer->addLine(sprintf("%s [%s/%s]", $bar, $at, $of));
        $outputBuffer->show();
    }
}