<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Output;

/**
 * @internal
 */
final class RawLine extends Line
{

    /**
     * Render the output of this line.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->contents;
    }
}