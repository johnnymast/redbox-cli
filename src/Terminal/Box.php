<?php

namespace Redbox\Cli\Terminal;

use Redbox\Cli\Attributes\Route;
use Redbox\Cli\Output\Output;

class Box
{

    #[Route('box')]
    public function box(Output $output, Route $info,
                        int    $padding = 0,
                        int    $width = 0,
                        string $content = '',
                        string $char = '#',
                        string $align = 'left'
    )
    {

        if ($padding > $width) {
            $padding = $width;
        }

        if ($align == 'left') {
            $content = str_repeat(' ', $padding) . $content;
        }

        if ($align == 'right') {
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

        $output->addLine($top)
            ->addNewLine()
            ->addLine($middle)
            ->addNewLine()
            ->addLine($bottom)
            ->addNewLine()
            ->output();
    }

}