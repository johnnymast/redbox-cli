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

use Redbox\Cli\Output\RawLine;
use Redbox\Cli\Output\Style;

uses()
    ->beforeEach(function () {
        $this->defaultStyle = new Style();
    })
    ->group('output');

test('Constructed values should be remembered.', function () {

    $contents = 'raw content';

    $line = new RawLine($contents, $this->defaultStyle);

    $expected = $contents;
    $actual = $line->getContents();

    $this->assertEquals($expected, $actual);
});


//test('show', function () {
//    $this->acceptTrue(false);
//});
//
//test('fetch', function () {
//    $this->acceptTrue(false);
//});