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
class Box
{

    /**
     * Draw a box in the terminal.
     *
     * @param \Redbox\Cli\Output\OutputBuffer     $outputBuffer The output buffer to write to.
     * @param \Redbox\Cli\Router\Attributes\Route $route        The route object.
     * @param int                                 $padding      The box padding.
     * @param int                                 $width        The box width.
     * @param string                              $content      The box content.
     * @param string                              $char         The box writing char '#' by default.
     * @param string                              $align        The content alignment string left/right or center.
     *
     * @return void
     */
    #[Route('box')]
    public function box(OutputBuffer $outputBuffer,
                        Route        $route,
                        int          $padding = 0,
                        int          $width = 0,
                        string       $content = '',
                        string       $char = '#',
                        string       $align = 'left'
    ): void
    {

        if ($padding > $width) {
            $padding = $width;
        }

        if ($align === 'left') {
            $content = str_repeat(' ', $padding) . $content;
        }

        if ($align === 'right') {
            $content .= str_repeat(' ', $padding);
        }

        $content = match ($align) {
            'left' => str_pad($content, $width, ' ', STR_PAD_RIGHT),
            'right' => str_pad($content, $width, ' ', STR_PAD_LEFT),
            default => str_pad($content, $width, ' ', STR_PAD_BOTH),
        };

        $middle = sprintf('%s%s%s', $char, $content, $char);

        $top = str_repeat($char, strlen($middle));
        $bottom = str_repeat($char, strlen($middle));

        $outputBuffer->addLine($top)
            ->addNewLine()
            ->addLine($middle)
            ->addNewLine()
            ->addLine($bottom)
            ->addNewLine()
            ->show();
    }
}