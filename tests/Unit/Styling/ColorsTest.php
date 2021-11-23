<?php

use Pest\Datasets;
use Redbox\Cli\Cli;
use Redbox\Cli\Router\Router;
use Redbox\Cli\Router\Attributes\ColorRoute;

uses()
    ->beforeEach(function () {
        $this->cli = new Cli();
    })
    ->group('router');

test('All color foreground are defined', function($color) {
    $this->assertTrue($this->cli->getRouter()->hasRoute($color));

    $expected = ColorRoute::COLOR_TYPE_FOREGROUND;
    $actual = $this->cli->getRouter()->getRoute($color)['info']->getType();

    $this->assertEquals($expected, $actual);

})->with('colors');

test('All color background are defined', function($color) {
    $color .= 'Background';

    $this->assertTrue($this->cli->getRouter()->hasRoute($color));

    $expected = ColorRoute::COLOR_TYPE_BACKGROUND;
    $actual = $this->cli->getRouter()->getRoute($color)['info']->getType();

    $this->assertEquals($expected, $actual);

})->with('colors');

test('Dataset contains all colors defined', function() {
    $colorRoutes = $this->cli->getRouter()->getRoutesOfAttributeType(ColorRoute::class);
    $dataSet = Datasets::get('colors');


    foreach($colorRoutes as $route) {
        $name = $route['info']->getMethod();
        if ($route['info']->getType() == ColorRoute::COLOR_TYPE_FOREGROUND) {
            $this->assertContains($name, $dataSet);
        }
    }
});