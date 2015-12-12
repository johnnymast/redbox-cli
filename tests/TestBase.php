<?php
namespace Redbox\Cli\Tests;

use Redbox\Cli\Cli as CLI;

class TestBase extends \PHPUnit_Framework_TestCase
{
    protected $cli = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->cli = new CLI;
    }
}