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
use Redbox\Cli\Output\Line;

uses()
    ->beforeEach(function () {

        $this->defaultStyle = new Style();

        $this->redForeGroundColorStyle = new Style();
        $this->redForeGroundColorStyle->setForegroundColor('red');

        $this->blueBackgroundGroundColorStyle = new Style();
        $this->blueBackgroundGroundColorStyle->setBackgroundColor('blue');

        $this->mixedStyle = new Style();
        $this->mixedStyle->setForegroundColor('white');
        $this->mixedStyle->setBackgroundColor('red');
        $this->mixedStyle->setFontStyle('reset');
    })
    ->group('output');

test('Constructed values should be remembered.', function () {

    $contents = 'content';

    $line = new Line($contents, $this->defaultStyle);

    $expected = $contents;
    $actual = $line->getContents();

    $this->assertEquals($expected, $actual);
});

test("Line with foreground color should be rendered correct.", function () {
    $line = new Line("content", $this->redForeGroundColorStyle);

    $style = $line->getStyle();

    $expected = 'red';
    $actual = $style->getForegroundColor();

    $this->assertEquals($expected, $actual);

    $expected = "\u{001b}[31mcontent\u{001b}[0m";
    $actual = $line->render();

    $this->assertEquals($expected, $actual);
});

test("Line with background color should be rendered correct.", function () {
    $content = "content";
    $line = new Line($content, $this->blueBackgroundGroundColorStyle);

    $style = $line->getStyle();

    $expected = 'blue';
    $actual = $style->getBackgroundColor();

    $this->assertEquals($expected, $actual);

    $expected = "\u{001b}[0;44m{$$content}\u{001b}[0m";
    $actual = $line->render();

    $this->assertEquals($expected, $actual);
});

test("Line with background color and foreground color should be rendered correct.", function () {
    $line = new Line("content", $this->mixedStyle);

    $style = $line->getStyle();

    $expected = 'white';
    $actual = $style->getForegroundColor();

    $this->assertEquals($expected, $actual);

    $expected = 'red';
    $actual = $style->getBackgroundColor();

    $this->assertEquals($expected, $actual);
});
