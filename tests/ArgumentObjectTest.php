<?php
namespace Redbox\Cli\Tests;
use Redbox\Cli\Arguments;

class ArgumentObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Dataprovider for our 2 test methods.
     *
     * @return array
     */
    public function usageLineProvider()
    {
        return array(
            /* Test both long and short prefix + default value */
            [array('prefix'  => 'u', 'longPrefix' => 'user', 'description' => 'Username', 'required'  => true, 'name' => 'user', 'defaultValue' => 'me_myself_i'), '-u user, --user user, (default: me_myself_i)'],

            /* Test both long and short prefix */
            [array('prefix'  => 'u', 'longPrefix' => 'user', 'description' => 'Username', 'required'  => true, 'name' => 'user'), '-u user, --user user'],

            /* Test long prefix */
            [array('longPrefix' => 'user', 'description' => 'Username', 'required'  => true, 'name' => 'user'), '--user user'],

            /* Test short prefix */
            [array('prefix'  => 'u', 'description' => 'Username', 'required'  => true, 'name' => 'user'), '-u user'],

            /* Test no prefix */
            [array('description' => 'Username', 'required'  => true, 'name' => 'user'), 'user'],
        );
    }

    /**
     * Test that \Redbox\Cli\Arguments\Argument::usageInfo() returns the correct layout.
     *
     * @dataProvider usageLineProvider
     */
    public function testUsageInfoIsCorrect($args = array(), $usage = '')
    {
        $argument = new Arguments\Argument($args);
        $usageInfo = $argument->usageInfo();
        $this->assertEquals($usage, $usageInfo);
    }

    /**
     * Test that \Redbox\Cli\Arguments\Argument::usageLine() returns the correct layout.
     *
     * @dataProvider usageLineProvider
     */
    public function testUsageLineIsCorrect($args = array(), $usage = '') {
        $argument = new Arguments\Argument($args);
        $expected = sprintf(Arguments\Argument::LINE_FMT, $usage, $args['description']);
        $actual   = $argument->usageLine();
        $this->assertEquals($expected, $actual);
    }
}