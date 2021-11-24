<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Tests\Unit\Arguments;

use Redbox\Cli\Arguments\Arguments;
use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

uses()
    ->beforeEach(function () {
        $this->cli = new Cli();
        $this->cli->arguments->addOption(
            'username',
            'u',
            Option::OPTION_REQUIRED,
            "The username",
            "default value here"
        );
    })
    ->group('arguments');

test('Should return usage as variable value.', function () {


    ob_start();
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $expected = "";
    $actual = ob_get_clean();

    $this->assertEquals($expected, $actual);

    $this->cli->mute(false);

    ob_start();
    $this->cli->arguments->usage();
    $haystack = ob_get_clean();
    $needle = "-u, --username";


    $this->assertStringContainsString($needle, $haystack);
    $this->assertNotEmpty($haystack);
});

test("Should be able to output short prefix.", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "-u";
    $haystack = $this->cli->getOutputBuffer()->fetch();

    $this->assertStringContainsString($needle, $haystack);
});

test("Should be able to output long prefix.", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "--username";
    $haystack = $this->cli->getOutputBuffer()->fetch();
    $this->cli->mute(true);

    $this->assertStringContainsString($needle, $haystack);
});

test("Should be able to output default value.", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "default value here";
    $haystack = $this->cli->getOutputBuffer()->fetch();

    $this->assertStringContainsString($needle, $haystack);
});

test('setDescription should persist the description.', function () {
    $description = 'My favorite app version ' . time();

    $this->cli->arguments->setDescription($description);

    $expected = $description;
    $actual = $this->cli->arguments->getDescription();

    $this->assertEquals($expected, $actual);
});

test('operation with name default cannot be registered.', function () {
    $default = Arguments::DEFAULT_OPERATION;
    $message = "{$default} is an reserved operation name.";
    $this->expectExceptionMessage($message);

    $this->cli->arguments->registerOperation($default);
});

test('getOperation should return false if operation is not known.', function () {
    $operationName = 'my_operation';
    $result = $this->cli->arguments->getOperation($operationName);

    expect($result)->toBeFalse();
});

test('usage should include app description.', function () {
    global $argv;
    $command = $argv[0];

    $description = 'My test description ' . time();

    $expected = $command;

    ob_start();
    $this->cli->arguments->usage();
    $content = ob_get_clean();

    $actual = current(explode("\n", $content));
    $this->assertEquals($expected, $actual);

    $this->cli->setDescription($description);

    $expected = "{$command} - {$description}";

    ob_start();
    $this->cli->arguments->usage();
    $content = ob_get_clean();

    $actual = current(explode("\n", $content));
    $this->assertEquals($expected, $actual);
});

test('default operation name should not be shown in the usage.', function () {
    $defaultOperation = Arguments::DEFAULT_OPERATION;

    /**
     * Add an option that we can show.
     */
    $this->cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_OPTIONAL,
        "Username to log in with.");

    ob_start();
    $this->cli->arguments->usage();
    $content = ob_get_clean();

    $result = explode("\n", $content)[3];

    expect($result)->not->toContain($defaultOperation);
});

test('custom operation is shown in the usage.', function () {

    $customOperation = 'test';

    $this->cli
        ->arguments
        ->registerOperation($customOperation)
        ->addOption(
        'user',
        'u',
        Option::OPTION_OPTIONAL,
        "Username to log in with.");

    ob_start();
    $this->cli->arguments->usage();
    $content = ob_get_clean();

    $result = explode("\n", $content)[3];

    expect($result)->toContain($customOperation);
});

test('An error should be raised if a non-existing method is called as magic function.', function () {
    $this->expectErrorMessage('Call to undefined method Redbox\Cli\Arguments\Arguments::getUndefinedArgumentsFunction()');
    $this->cli->arguments->getUndefinedArgumentsFunction();
});