<?php

namespace Redbox\Cli\Terminal;

use Redbox\Cli\Attributes\Route;
use Redbox\Cli\Output\Output;

class ProgressBar
{
    private const DELETE_CHAR = 13;
    //private

    #[Route('progress')]
    function progress(Output $output, Route $info, $at, $of)
    {
        $bar = str_repeat('#', $at) . str_repeat(".", ($of - $at));


        $output->addRawLine(chr(self::DELETE_CHAR));
        $output->addLine(sprintf("%s [%s/%s]", $bar, $at, $of));
        $output->output();
    }
}