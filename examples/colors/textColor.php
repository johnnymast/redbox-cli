<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This example will show you can read
 * the input given from the command line.
 */

use Redbox\Cli\Cli;

require __DIR__ . '/../autoload.php';

$cli = new Cli();


$cli->red('This text is now red');
$cli->red()->write('Also an other way to write a red line.');

$cli->redBackground('This background color red.');
$cli->redBackground()
    ->black('This background color red. And black text');

$cli->greenBackground()
    ->blue()
    ->write('Green background blue text.');

$cli
    ->red()
    ->whiteBackground()
    ->write("test\n");

$cli->write("Other text.");

$cli->red()->blueBackground('Red text blue background');
$cli
    ->red()
    ->blueBackground()
    ->write('Alternate: Red text blue background');