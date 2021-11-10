<?php
/**
 * This example will show you can read
 * the input given from the command line.
 */

use Redbox\Cli\Cli;

require __DIR__ . '/../autoload.php';

$cli = new Cli();

$cli->red()->whiteBackground("MESSAGE");
$cli->redBackground()