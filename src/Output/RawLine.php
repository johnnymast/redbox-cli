<?php

namespace Redbox\Cli\Output;

class RawLine extends Line
{

    public function render(): string
    {
        return $this->message;
    }
}