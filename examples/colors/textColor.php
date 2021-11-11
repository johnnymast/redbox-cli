<?php
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
