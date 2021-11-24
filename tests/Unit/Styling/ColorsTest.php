<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Tests\Unit\Styling;

use Pest\Datasets;
use Redbox\Cli\Cli;
use Redbox\Cli\Output\OutputBuffer;
use Redbox\Cli\Router\Attributes\ColorRoute;

uses()
    ->beforeEach(function () {
        $this->cli = new Cli();
    })
    ->group('router');

test('All foreground colors are defined', function ($color) {
    $this->assertTrue($this->cli->getRouter()->hasRoute($color));

    $expected = ColorRoute::COLOR_TYPE_FOREGROUND;
    $actual = $this->cli->getRouter()->getRoute($color)['info']->getType();

    $this->assertEquals($expected, $actual);

})->with('colors');

test('All background colors are defined', function ($color) {
    $color .= 'Background';

    $this->assertTrue($this->cli->getRouter()->hasRoute($color));

    $expected = ColorRoute::COLOR_TYPE_BACKGROUND;
    $actual = $this->cli->getRouter()->getRoute($color)['info']->getType();

    $this->assertEquals($expected, $actual);

})->with('colors');

test('Dataset contains all colors defined.', function () {
    $colorRoutes = $this->cli->getRouter()->getRoutesOfAttributeType(ColorRoute::class);
    $dataSet = Datasets::get('colors');


    foreach ($colorRoutes as $route) {
        $name = $route['info']->getMethod();
        if ($route['info']->getType() == ColorRoute::COLOR_TYPE_FOREGROUND) {
            $this->assertContains($name, $dataSet);
        }
    }
});

test('Color functions should return instance of OutputBuffer.', function () {
    $colorRoutes = $this->cli->getRouter()->getRoutesOfAttributeType(ColorRoute::class);
    $outputBuffer = $this->cli->getOutputBuffer();

    foreach ($colorRoutes as $route) {
        $info = $route['info'];

        $returnValue = $route['callable']($outputBuffer, $info, "");
        expect($returnValue)->toBeInstanceOf(OutputBuffer::class);
    }
});

test('Color call with string should directly output to screen.', function() {
    $colorRoutes = $this->cli->getRouter()->getRoutesOfAttributeType(ColorRoute::class);
    $outputBuffer = $this->cli->getOutputBuffer();

    foreach ($colorRoutes as $index => $route) {
        $info = $route['info'];
        $message = "Message: ".$index;

        ob_start();
        $route['callable']($outputBuffer, $info, $message);
        $output = ob_get_clean();

        expect($output)->toContain($message);
    }
});