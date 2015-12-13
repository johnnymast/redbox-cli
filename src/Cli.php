<?php
namespace Redbox\Cli;
use Redbox\Cli\Arguments\Manager as ArgumentManager;
use Redbox\Cli\Arguments;

class Cli {


    /**
     * An instance of the Argument Manager class
     *
     * @var \Redbox\Cli\Arguments\Manager $arguments
     */
    public $arguments;

    public function __construct()
    {
        $this->setManager( new ArgumentManager() );
    }

    /**
     * @param \Redbox\Cli\Arguments\Manager $manager
     */
    public function setManager(ArgumentManager $manager)
    {
        $this->arguments = $manager;
    }
}