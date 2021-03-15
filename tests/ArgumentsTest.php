<?php


namespace Redbox\Cli\Tests;

use PHPUnit\Framework\TestCase;
use Redbox\Cli\Arguments\Argument;
use function \Redbox\Cli\Arguments\mockGetOptToReturn;
use function \Redbox\Cli\Arguments\resetGetOptMock;
use Redbox\Cli\Cli;


/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Arguments
 */
class ArgumentsTest extends TestCase
{
    
    /**
     * Before every test we remove the
     * return value of the fake getopt.
     *
     */
    protected function setUp(): void
    {
        resetGetOptMock();
    }
    
    /**
     * dataProvider for the testUsageLineIsCorrect() test
     *
     * @return array
     */
    public function usageProvider()
    {
        global $argv;
        $cmd = $argv[0];
        
        return [
            /* Test short prefix */
          [
            [
              'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'defaultValue' => 'me_myself_i',
                'required' => true,
              ],
            ],
            "Usage: ".$cmd." [-u user, --user user, (default: me_myself_i)]\n\nRequired Arguments:\n\t-u user, --user user, (default: me_myself_i)\n\t\tUsername\n\n",
          ],
            
            /* Test required and optional arguments */
          [
            [
              'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'defaultValue' => 'me_myself_i',
                'required' => true,
              ],
              'iterations' => [
                'prefix' => 'i',
                'longPrefix' => 'iterations',
                'description' => 'Number of iterations',
                'castTo' => 'int',
              ],
            ],
            "Usage: ".$cmd." [-u user, --user user, (default: me_myself_i)] [-i iterations, --iterations iterations]\n\nRequired Arguments:\n\t-u user, --user user, (default: me_myself_i)\n\t\tUsername\n\nOptional Arguments:\n\t-i iterations, --iterations iterations\n\t\tNumber of iterations\n\n",
          ],
        ];
    }
    
    /**
     * This test will fail because the test did not set the require -u or --user
     * argument.
     *
     * @coversDefaultClass       \Redbox\Cli\Parser
     */
    public function testRequiredArgumentIsNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The following arguments are required: user.");
        
        $cli = new Cli();
        $cli->arguments->add([
          'user' => [
            'prefix' => 'u',
            'longPrefix' => 'user',
            'description' => 'Username',
            'required' => true,
          ],
        ]);
        $cli->arguments->parse();
    }
    
    /**
     * Test that a required argument has the correct values. This might look
     * silly but it is required to be tested.
     */
    public function test_required_parameter_has_correct_value()
    {
        $cli = new Cli();
        $cli->arguments->add([
          'q' => [
            'prefix' => 'q',
            'description' => 'Set php values',
            'required' => true,
          ],
        ]);
        
        mockGetOptToReturn(['q' => 'brownfox']);
        
        $cli->arguments->parse();
        
        $expected = "brownfox";
        $actual = $cli->arguments->get('q');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test that the parser detects if the value of an argument
     * is the default parameter.
     */
    public function testArgumentIsDefaultValue()
    {
        $cli = new Cli();
        $cli->arguments->add([
          'q' => [
            'prefix' => 'q',
            'description' => 'Make the code go eek!',
            'defaultValue' => 'eek',
          ],
        ]);
        
        $cli->arguments->parse();
        
        $actual = $cli->arguments->hasDefaultValue('q');
        
        $this->assertTrue($actual);
    }
    
    
    /**
     * Test if a parameter is passed with a different value then the default value that
     * its different from the default value for this parameter.
     */
    public function testArgumentIsNotDefaultValue()
    {
        mockGetOptToReturn(['q' => 'other then default value']);
        
        $cli = new Cli();
        $cli->arguments->add([
          'q' => [
            'prefix' => 'q',
            'description' => 'Make the code go eek!',
            'defaultValue' => 'eek',
          ],
        ]);
        
        
        $cli->arguments->parse();
        
        $actual = $cli->arguments->hasDefaultValue('q');
        
        $this->assertFalse($actual);
    }
    
    /**
     * This test will ensure that a default value will be set even if it was not passed to the
     * commandline and that Redbox\Cli\Arguments\Arguments\Manager::hasDefaultValue will inform us that the default value has been set.
     */
    public function test_if_default_value_isset_when_no_argument_is_passed()
    {
        $cli = new Cli();
        
        /*
         * Setup the rules of engagement
         */
        $cli->arguments->add([
          'targetpath' => [
            'prefix' => 't',
            'longPrefix' => 'targetpath',
            'description' => 'Path',
            'defaultValue' => '/var/log',
          ],
        ]);
        $cli->arguments->parse();
        $this->assertEquals($cli->arguments->get('targetpath'), '/var/log');
        $this->assertTrue($cli->arguments->hasDefaultValue('targetpath'));
    }
    
    /**
     * Test if Arguments\Argument::getDefaultValue() returns false if the option
     * has no default value.
     *
     * @throws \Exception
     */
    public function test_getdefaultvalue_returns_false_if_non_defined()
    {
        $cli = new Cli();
        
        /*
         * Setup the rules of engagement
         */
        $cli->arguments->add([
          'targetpath' => [
            'prefix' => 't',
            'longPrefix' => 'targetpath',
            'description' => 'Path',
          ],
        ]);
        $cli->arguments->parse();
        
        $actual = $cli->arguments->getDefaultValue('targetpath');
        $this->assertFalse($actual);
    }
    
    /**
     * Test if Arguments\Argument::getDefaultValue() returns the define value if
     * argument was not passed trough the commandline.
     *
     * @throws \Exception
     */
    public function test_getdefaultvalue_returns_defined_value()
    {
        $cli = new Cli();
        
        /*
         * Setup the rules of engagement
         */
        $cli->arguments->add([
          'targetpath' => [
            'prefix' => 't',
            'longPrefix' => 'targetpath',
            'description' => 'Path',
            'defaultValue' => '/var/log'
          ],
        ]);
        $cli->arguments->parse();
        
        $actual = $cli->arguments->getDefaultValue('targetpath');
        $expected = '/var/log';
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test that Arguments\Argument::usageLine() returns the correct layout.
     *
     * @dataProvider usageProvider
     *
     * @param  array   $args
     * @param  string  $expected
     *
     * @throws \Exception
     */
    public function testUsageLineIsCorrect($args = [], $expected = '')
    {
        $this->expectOutputString($expected);
        
        $cli = new Cli();
        $cli->arguments->add($args);
        $cli->arguments->parse();
        $cli->arguments->usage();
    }
}