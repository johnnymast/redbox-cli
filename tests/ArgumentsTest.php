<?php
namespace Redbox\Cli\Tests;
use Redbox\Cli\Cli;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Arguments
 */
class ArgumentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This test will fail because the test did not set the require -u or --user
     * argument.
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage The following arguments are required: user.
     * @coversDefaultClass       \Redbox\Cli\Parser
     */
    public function testRequiredArgumentIsNotFound()
    {
        $cli = new Cli();
        $cli->arguments->add([
            'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'required' => true,
            ]
        ]);
        $cli->arguments->parse(true);
    }



    public function testRequiredParameterHasCorrectValue()
    {
        $cli = new Cli();
        $cli->arguments->add([
            'q' => [
                'prefix'      => 'q',
                'description' => 'Set php values',
                'required' => true,
            ]
        ]);

        $cli->arguments->parse();
        $this->assertEquals($cli->arguments->get('q'), 'brownfox');

    }


    /**
     * This test will ensure that a default value will be set even if it wasnt passwd to the
     * commandline and that Redbox\Cli\Arguments\Arguments\Manager::hasDefaultValue will inform us that the default value has been set.
     */
    public function test_if_default_value_isset_when_no_argument_is_passed() {
        $cli = new Cli();

        /*
         * Setup the rules of engagement
         */
        $cli->arguments->add([
            'targetpath' => [
                'prefix'       => 't',
                'longPrefix'   => 'targetpath',
                'description'  => 'Path',
                'defaultValue' => '/var/log',
            ]
        ]);
        $cli->arguments->parse();
        $this->assertEquals($cli->arguments->get('targetpath'), '/var/log');
        $this->assertTrue($cli->arguments->hasDefaultValue('targetpath'));
    }
}