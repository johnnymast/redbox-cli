<?php

use Redbox\Cli\Output\OutputBuffer;
use Redbox\Cli\Router\Attributes\ColorRoute;
use Redbox\Cli\Router\Attributes\Route;
use Redbox\Cli\Router\Router;
use Redbox\Cli\Cli;

uses()
    ->beforeEach(function () {
        $this->cli = new Cli();
        $this->router = new Router($this->cli);
    })
    ->group('router');

class TestRoute
{
    protected bool $called = false;

    #[Route('testHandle')]
    public function handle()
    {
        $this->called = true;
    }

    public function isCalled(): bool
    {
        return $this->called;
    }
}

class TestRoute2
{
    protected bool $called = false;

    #[Route('testHandle2')]
    public function handle()
    {
        $this->called = true;
    }
}

test('addRoute one route should work with string.', function () {

    $this->router->addRoute(TestRoute::class);

    $actual = $this->router->hasRoute('testHandle');
    $this->assertEquals(true, $actual);

    $this->router->execute('testHandle', []);

    $route = $this->router->getRoute('testHandle');

    $this->assertEquals(true, $route['subject']->isCalled());
});

test('addRoute route should work with object.', function () {

    $this->router->addRoute(new class {
        protected bool $called = false;

        #[Route('testHandle')]
        public function handle()
        {
            $this->called = true;
        }

        public function isCalled(): bool
        {
            return $this->called;
        }
    });

    $actual = $this->router->hasRoute('testHandle');
    $this->assertEquals(true, $actual);

    $this->router->execute('testHandle', []);

    $route = $this->router->getRoute('testHandle');
    $this->assertEquals(true, $route['subject']->isCalled());
});

test('addManyRoutes should work with strings', function () {
    $this->router->addManyRoutes([
        TestRoute::class,
        TestRoute2::class,
    ]);

    $actual = $this->router->hasRoute('testHandle');
    $this->assertEquals(true, $actual);

    $actual = $this->router->hasRoute('testHandle2');
    $this->assertEquals(true, $actual);
});


test('addManyRoutes should work with objects', function () {
    $this->router->addManyRoutes([
        new TestRoute,
        new TestRoute2,
    ]);

    $actual = $this->router->hasRoute('testHandle');
    $this->assertEquals(true, $actual);

    $actual = $this->router->hasRoute('testHandle2');
    $this->assertEquals(true, $actual);
});

test('hasRoute should return bool if true false if not.', function () {
    $this->router->addRoute(TestRoute::class);

    $actual = $this->router->hasRoute('testHandle');
    $this->assertEquals(true, $actual);

    $actual = $this->router->hasRoute('testHandle2');
    $this->assertEquals(false, $actual);
});

test('getAllRoutes should return the number of routed methods.', function () {
    $this->router->addManyRoutes([
        new TestRoute,
        new TestRoute2,
    ]);

    /**
     * Be because of testHandle and testHandle2
     */
    $expected = 2;
    $actual = count($this->router->getAllRoutes());

    $this->assertEquals($expected, $actual);
});

test('getRouter info should contain an instance of the attribute class', function () {
    $this->router->addRoute(TestRoute::class);

    $route = $this->router->getRoute('testHandle');

    $expected = Route::class;
    $this->assertInstanceOf($expected, $route['info']);
});