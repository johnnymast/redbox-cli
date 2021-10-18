<?php

namespace Redbox\Cli\Tests\Unit;

use Redbox\Cli\Arguments;
use PHPUnit\Framework\TestCase;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Manager
 */
class ManagerTest extends TestCase
{
    
    /**
     * @var Arguments\Manager
     */
    private $manager;
    
    protected function setUp(): void
    {
        $this->manager = new Arguments\Manager();
    }
    
    /**
     * Test if a value being set is retrievable via \Redbox\Cli\Arguments\Manager::get
     */
    public function test_if_get_returns_the_same_as_been_set()
    {
        $this->manager->set('key', 'val');
        
        $expected = 'val';
        $actual = $this->manager->get('key');
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * The function has returns true if argument is provided.
     */
    public function test_has_returns_true_if_a_value_exists_with_key()
    {
        $this->manager->set('key', 'val');
        $actual = $this->manager->has('key');
        
        $this->assertTrue($actual);
    }
    
    /**
     * The function has returns false if argument is not passed to app.
     */
    public function test_has_returns_false_if_a_value_does_not_exist_with_key()
    {
        $actual = $this->manager->has('key');
        $this->assertFalse($actual);
    }
    
    /**
     * This test will ensure that \Redbox\Cli\Arguments\Manager::get returns false
     * if an argument is unknown (or not parsed).
     */
    public function test_if_get_returns_false_on_unknown_argument()
    {
        $actual = $this->manager->get('non_existing');
        $this->assertFalse($actual);
    }
    
//    public function test
}

