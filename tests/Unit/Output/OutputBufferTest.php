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

use Redbox\Cli\Output\OutputBuffer;
use Redbox\Cli\Output\Style;


uses()
    ->beforeEach(function () {
        $this->outputBuffer = new OutputBuffer();
    })
    ->group('output');

test('setSilentMode should enable silent mode', function() {
    $this->assertFalse($this->outputBuffer->isSilent());

    $this->outputBuffer->setSilentMode(true);

    $this->assertTrue($this->outputBuffer->isSilent());
});


test('addLine should add one new line to the output buffer.', function() {
    expect($this->outputBuffer->getLines())->toHaveCount(0);

    $contents1 = "Content";
    $this->outputBuffer->addLine($contents1);

    $lines = $this->outputBuffer->getLines();
    expect($this->outputBuffer->getLines())->toHaveCount(1);

    $expected = $contents1;
    $actual = current($lines)->getContents();

    $this->assertEquals($expected, $actual);
});

test('addLines should add multiple new lines to the output buffer.', function() {
    expect($this->outputBuffer->getLines())->toHaveCount(0);

    $contents1 = "Content 1";
    $contents2 = "Content 2";
    $this->outputBuffer->addLines([
        $contents1,
        $contents2,
    ]);

    $lines = $this->outputBuffer->getLines();
    expect($this->outputBuffer->getLines())->toHaveCount(2);

    $expected = $contents1;
    $actual = $lines[0]->getContents();

    $this->assertEquals($expected, $actual);

    $expected = $contents2;
    $actual = $lines[1]->getContents();

    $this->assertEquals($expected, $actual);
});

test('addNewLine should add one new line with a newline character to the output buffer.', function() {
    expect($this->outputBuffer->getLines())->toHaveCount(0);

    $this->outputBuffer->addNewLine();

    $lines = $this->outputBuffer->getLines();
    expect($this->outputBuffer->getLines())->toHaveCount(1);

    $expected = "\n";
    $actual = current($lines)->getContents();

    $this->assertEquals($expected, $actual);
});

test('addRawLine should add one new line without any style.', function() {
    expect($this->outputBuffer->getLines())->toHaveCount(0);

    $contents = "raw line contents";
    $this->outputBuffer->addRawLine($contents);

    $lines = $this->outputBuffer->getLines();
    expect($this->outputBuffer->getLines())->toHaveCount(1);

    $expected = $contents;
    $actual = current($lines)->getContents();

    $this->assertEquals($expected, $actual);

    $style = $lines[0]->getStyle();

    $expected = '';
    $actual = $style->getForegroundColor();
    $this->assertEquals($expected, $actual);

    $actual = $style->getBackgroundColor();
    $this->assertEquals($expected, $actual);
});

test('getStyle should return the current style of the output buffer.', function() {
    expect($this->outputBuffer->getStyle())->toBeInstanceOf(Style::class);
});
