<?php

namespace Redbox\Cli;

use Redbox\Cli\Attributes\Route;
use Redbox\Cli\Router\Router;

class Terminal
{

    #[Route('write')]
    public function write(Cli $cli, $line) {
        echo "{$line}";
    }
}