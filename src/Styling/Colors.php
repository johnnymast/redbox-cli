<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Styling;

use Redbox\Cli\Attributes\ColorRoute;
use Redbox\Cli\Attributes\Route;
use Redbox\Cli\Output\OutputBuffer;

/**
 * @internal
 */
class Colors
{

    private function _complete(OutputBuffer $output, string $str = ''): OutputBuffer
    {
        if ($str !== '') {
            $output->addLine($str);
            $output->show();
        }
        return $output;
    }

    #[Route('reset')]
    public function reset(OutputBuffer $output): OutputBuffer
    {
        $output->getStyle()->reset();
        return $this->_complete($output);
    }

    #[
        ColorRoute('black', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('blackBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function black(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('black');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('black');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('red', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('redBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function red(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('red');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('red');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('green', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('greenBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function green(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('green');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('green');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('yellow', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('yellowBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function yellow(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('yellow');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('yellow');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('blue', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('blueBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function blue(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('blue');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('blue');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('magenta', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('magentaBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function magenta(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('magenta');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('magenta');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('cyan', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('cyanBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function cyan(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {
        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('cyan');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('cyan');
        }
        return $this->_complete($output, $string);
    }

    #[
        ColorRoute('white', ColorRoute::COLOR_TYPE_FOREGROUND),
        ColorRoute('whiteBackground', ColorRoute::COLOR_TYPE_BACKGROUND)
    ]
    public function white(OutputBuffer $output, ColorRoute $info, string $string = ''): OutputBuffer
    {

        if ($info->getType() === ColorRoute::COLOR_TYPE_FOREGROUND) {
            $output->getStyle()->setForegroundColor('white');
        } elseif ($info->getType() === ColorRoute::COLOR_TYPE_BACKGROUND) {
            $output->getStyle()->setBackgroundColor('white');
        }
        return $this->_complete($output, $string);
    }
}