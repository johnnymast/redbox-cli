<?php

namespace Redbox\Cli\Tests;

use Redbox\Cli\Arguments;
use PHPUnit\Framework\TestCase;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Argument
 */
class ArgumentObjectTest extends TestCase
{
    /**
     * dataProvider for our 2 test methods.
     *
     * @return array
     */
    public function usageLineProvider()
    {
        return [
            /* Test both long and short prefix + default value */
            [
                [
                    'prefix' => 'u',
                    'longPrefix' => 'user',
                    'description' => 'Username',
                    'required' => true,
                    'name' => 'user',
                    'defaultValue' => 'me_myself_i',
                ],
                '-u user, --user user, (default: me_myself_i)',
            ],

            /* Test both long and short prefix */
            [
                [
                    'prefix' => 'u',
                    'longPrefix' => 'user',
                    'description' => 'Username',
                    'required' => true,
                    'name' => 'user',
                ],
                '-u user, --user user',
            ],

            /* Test long prefix */
            [
                ['longPrefix' => 'user', 'description' => 'Username', 'required' => true, 'name' => 'user'],
                '--user user',
            ],

            /* Test short prefix */
            [['prefix' => 'u', 'description' => 'Username', 'required' => true, 'name' => 'user'], '-u user'],

            /* Test no prefix */
            [['description' => 'Username', 'required' => true, 'name' => 'user'], 'user'],
        ];
    }

    /**
     * Test that Arguments\Argument::usageInfo() returns the correct layout.
     *
     * @dataProvider usageLineProvider
     *
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     */
    public function testUsageInfoIsCorrect($args = [], $usage = '')
    {
        $argument = new Arguments\Argument($args);
        $usageInfo = $argument->usageInfo();
        $this->assertEquals($usage, $usageInfo);
    }

    /**
     * Test that Arguments\Argument::usageLine() returns the correct layout.
     *
     * @dataProvider usageLineProvider
     *
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     */
    public function testUsageLineIsCorrect($args = [], $usage = '')
    {
        $argument = new Arguments\Argument($args);
        $expected = sprintf(Arguments\Argument::LINE_FMT, $usage, $args['description']);
        $actual = $argument->usageLine();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the __isset magic function.
     *
     * @dataProvider usageLineProvider
     *
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     */
    public function testIssetWorksCorrectly($args = [], $usage = '')
    {
        $argument = new Arguments\Argument($args);
        $expected = true;
        $actual = isset($argument->name);

        $this->assertTrue($expected, $actual);
    }

    /**
     * Test the __unset magic function.
     *
     * @dataProvider usageLineProvider
     *
     * @param array $args The arguments to test.
     */
    public function testUnsetWorksCorrectly($args = [])
    {
        $argument = new Arguments\Argument($args);
        unset($argument->name);

        $expected = false;
        $actual = isset($argument->name);

        $this->assertFalse($expected, $actual);
    }
}