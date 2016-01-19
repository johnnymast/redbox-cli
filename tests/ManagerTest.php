<?php
namespace Redbox\Cli\Tests;
use Redbox\Cli\Arguments;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Manager
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if a value being set is retrievable via \Redbox\Cli\Arguments\Manager::get
     */
    public function test_if_get_returns_the_same_as_been_set()
    {
        $manager = new Arguments\Manager();
        $manager->set('key', 'val');
        $this->assertEquals($manager->get('key'), 'val');
    }

    /**
     * This test will ensure that \Redbox\Cli\Arguments\Manager::get returns false
     * if an argument is unknown (or not parsed).
     */
    public function test_if_get_returns_false_on_unknown_argument()
    {
        $manager = new Arguments\Manager();
        $this->assertFalse($manager->get('non_existing'));
    }
}

