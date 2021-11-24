<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Tests\Unit\Output;

use Redbox\Cli\Output\Style;

uses()
    ->beforeEach(function () {
        $this->defaultStyle = new Style();
    })
    ->group('output');


test('isset should return true if a style by key is defined.', function() {
    $actual = isset($this->defaultStyle->foreground_color);
    $this->assertTrue($actual);
});

test('isset should return false if a style by key is not defined.', function() {
    $actual = isset($this->defaultStyle->no_existing_style_key);
    $this->assertFalse($actual);
});

test('__get should return null if the style key is not defined.', function() {
    $actual = $this->defaultStyle->no_existing_style_key;
    $expected = null;
    $this->assertEquals($expected, $actual);
});

test('__get should return the if the style key is defined.', function() {
    $value = 'red';
    $this->defaultStyle->foreground_color = $value;

    $actual = $this->defaultStyle->foreground_color;
    $expected = $value;
    $this->assertEquals($expected, $actual);
});


test('An error should be raised if a non-existing style key is called as magic function.', function() {
    $this->expectErrorMessage('Call to undefined method Redbox\Cli\Output\Style::getUndefinedProperty()');
    $this->defaultStyle->getUndefinedProperty();
});


test('__call should work with uppercase style keys.', function() {
    $value = 'red';
    $this->defaultStyle->foreground_color = $value;

    $actual = $this->defaultStyle->getForeground_COLOR();
    $expected = $value;
    $this->assertEquals($expected, $actual);
});
