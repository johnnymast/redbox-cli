<?php
namespace Redbox\Cli\Tests;
use Redbox\Cli\Arguments;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Manager
 */
class ManagerTest extends TestBase
{
    public function test_if_get_returns_the_same_as_been_set()
    {
        $manager = new Arguments\Manager();
        $manager->set('key', 'val');

        $this->assertEquals($manager->get('key'), 'val');
    }
}