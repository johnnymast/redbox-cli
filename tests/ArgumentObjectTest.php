<?php
/**
 * ArgumentObjectTest.php
 *
 * PHP version 7.3 and up.
 *
 * @category Tests
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */

namespace Redbox\Cli\Tests;

use Redbox\Cli\Arguments;
use PHPUnit\Framework\TestCase;

/**
 * This class will test the argument class.
 *
 * @coversDefaultClass \Redbox\Cli\Arguments\Argument
 *
 * @category Tests
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class ArgumentObjectTest extends TestCase
{
    /**
     * DataProvider for our 2 test methods.
     *
     * @return array
     */
    public function usageLineProvider(): array
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
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     *
     * @dataProvider usageLineProvider
     *
     * @return void
     */
    public function testUsageInfoIsCorrect($args = [], $usage = ''): void
    {
        $argument = new Arguments\Argument($args);
        $usageInfo = $argument->usageInfo();
        $this->assertEquals($usage, $usageInfo);
    }

    /**
     * Test that Arguments\Argument::usageLine() returns the correct layout.
     *
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     *
     * @dataProvider usageLineProvider
     *
     * @return void
     */
    public function testUsageLineIsCorrect($args = [], $usage = ''): void
    {
        $argument = new Arguments\Argument($args);
        $expected = sprintf(Arguments\Argument::LINE_FMT, $usage, $args['description']);
        $actual = $argument->usageLine();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the __isset magic function.
     *
     * @param array  $args  The arguments to test.
     * @param string $usage The argument to test with.
     *
     * @dataProvider usageLineProvider
     *
     * @return void
     */
    public function testIssetWorksCorrectly($args = [], $usage = ''): void
    {
        $argument = new Arguments\Argument($args);
        $expected = true;
        $actual = isset($argument->name);

        $this->assertTrue($expected, $actual);
    }

    /**
     * Test the __unset magic function.
     *
     * @param array $args The arguments to test.
     *
     * @dataProvider usageLineProvider
     *
     * @return void
     */
    public function testUnsetWorksCorrectly($args = []): void
    {
        $argument = new Arguments\Argument($args);
        unset($argument->name);

        $expected = false;
        $actual = isset($argument->name);

        $this->assertFalse($expected, $actual);
    }
}
