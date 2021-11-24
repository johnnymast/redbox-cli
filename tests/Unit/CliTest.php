<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Tests;

use Redbox\Cli\Cli;

uses()
    ->beforeEach(function () {
        $this->cli = new Cli();
    })
    ->group('core');

test('setDescription forwards description to arguments class.', function () {
    $description = 'my awesome description';

    $expected = '';
    $actual = $this->cli->arguments->getDescription();
    $this->assertEquals($expected, $actual);

    $this->cli->setDescription($description);
    $expected = $description;
    $actual = $this->cli->arguments->getDescription();
    $this->assertEquals($expected, $actual);
});

test('write should add a line to the screen.', function () {
    $string = 'Hello world ' . time();

    ob_start();
    $this->cli->write($string);
    $content = ob_get_clean();


    $expected = $string;
    $actual = $content;
    $this->assertEquals($expected, $actual);
});

test('read returns the contents of the OutputBuffer.', function () {
    $string = 'read test ' . time();

    $this->cli->getOutputBuffer()->addLine($string);
    $content = $this->cli->read();

    $expected = $string;
    $actual = $content;
    $this->assertEquals($expected, $actual);
});

test('newLine adds newLine to OutputBuffer.', function () {
    $string = 'newline test ' . time();

    $this->cli
        ->newLine()
        ->getOutputBuffer()
        ->addLine($string);

    $content = $this->cli->read();

    $expected = "\n" . $string;
    $actual = $content;
    $this->assertEquals($expected, $actual);
});

test('newLine returns instance of Redbox\Cli\Cli.', function () {
    expect($this->cli->newLine())->toBeInstanceOf(Cli::class);
});

test('calling a magic method should return an OutputBuffer instance.', function () {
    /**
     * The reset function resets the styling.
     */
    expect($this->cli->reset())->toBeInstanceOf(Cli::class);
});

test('An error should be raised if a non-existing method is called as magic function.', function () {
    $this->expectErrorMessage('Call to undefined method Redbox\Cli\Cli::getUndefinedFunction()');
    $this->cli->getUndefinedFunction();
});