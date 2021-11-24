<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Tests\Unit\Traits;

use Redbox\Cli\Traits\KeyValueTrait;

uses()
    ->beforeEach(function () {
        $this->test = new class {
            use KeyValueTrait;
        };
    })
    ->group('traits');

test('Setting and Getting values.', function () {
    $key = "my_key";
    $value = "My Dear Test Value.";

    $this->test->set($key, $value);

    $expected = $value;
    $actual = $this->test->get($key);

    $this->assertEquals($expected, $actual);
});

test('Should know if a key has been set.', function () {
    $key = "has_key";
    $value = "Dummy value";

    $this->test->set($key, $value);

    $actual = $this->test->has($key);

    $this->assertTrue($actual);
});

test('Should be able to remove a key and its value.', function () {
    $key = "remove_key";
    $value = "Remove value";

    /**
     * Set the value and test if
     * it has been set.
     */
    $this->test->set($key, $value);
    $actual = $this->test->has($key);
    $this->assertTrue($actual);

    /**
     * Remove the key
     */
    $this->test->remove($key);

    /**
     * Test if it was actually removed.
     */
    $actual = $this->test->has($key);
    $this->assertFalse($actual);
});

test('remove should return true if the key was found.', function() {
    $key = 'my_key';
    $value = 'my_value';

    $this->test->set($key, $value);

    $actual = $this->test->remove($key);

    $this->assertTrue($actual);
});

test('remove should return false if the key is not found.', function() {
    $key = 'some_non_existing_key';
    $actual = $this->test->remove($key);

    $this->assertFalse($actual);
});
