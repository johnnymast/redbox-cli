<?php
/**
 * ManagerTest.php
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
 * This class will test the arguments manager.
 *
 * @coversDefaultClass \Redbox\Cli\Arguments\Manager
 *
 * @category Tests
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class ManagerTest extends TestCase
{

    /**
     * Instance of the argument manager.
     *
     * @var Arguments\Manager
     */
    private $manager;

    /**
     * Setup a fresh instance of the arguments manager
     * for every test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->manager = new Arguments\Manager();
    }

    /**
     * Test if a value being set is retrievable via \Redbox\Cli\Arguments\Manager::get
     *
     * @return void
     */
    public function testIfGetReturnsTheSameAsBeenSet(): void
    {
        $this->manager->set('key', 'val');

        $expected = 'val';
        $actual = $this->manager->get('key');

        $this->assertEquals($expected, $actual);
    }

    /**
     * The function has returns true if argument is provided.
     *
     * @return void
     */
    public function testHasReturnsTrueIfAValueExistsWithKey(): void
    {
        $this->manager->set('key', 'val');
        $actual = $this->manager->has('key');

        $this->assertTrue($actual);
    }

    /**
     * The function has returns false if argument is not passed to app.
     *
     * @return void
     */
    public function testHasReturnsFalseIfAValueDoesNotExistWithKey(): void
    {
        $actual = $this->manager->has('key');
        $this->assertFalse($actual);
    }

    /**
     * This test will ensure that \Redbox\Cli\Arguments\Manager::get returns false
     * if an argument is unknown (or not parsed).
     *
     * @return void
     */
    public function testIfGetReturnsFalseOnUnknownArgument(): void
    {
        $actual = $this->manager->get('non_existing');
        $this->assertFalse($actual);
    }
}
