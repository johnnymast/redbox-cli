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

use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;
use function \Redbox\Cli\Arguments\{mockGetOptToReturn, resetGetOptMock};

uses()
    ->beforeEach(function () {
        resetGetOptMock();

        $this->cli = new Cli();
    })
    ->group('arguments');

test('Missing Required option should trigger exception.', function () {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage("The following options are required: user.");

    $this->cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_REQUIRED,
        "The username"
    );

    $this->cli->arguments->parse();
});

test('Required option has the correct value.', function () {

    $this->cli->arguments->addOption(
        'quickbrown',
        'q',
        Option::OPTION_REQUIRED,
        "Required values test"
    );

    mockGetOptToReturn(['q' => 'brownfox']);

    $this->cli->arguments->parse();

    $expected = "brownfox";
    $actual = $this->cli->arguments->get('quickbrown');

    $this->assertEquals($expected, $actual);
});

test('Required option with default value should use default value.', function () {

    $expected = "username default value.";

    $this->cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_REQUIRED,
        "The username",
        $expected
    );

    $this->cli->arguments->parse();

    $actual = $this->cli->arguments->get('user');

    $this->assertEquals($expected, $actual);
});

test('Required option should use provided value and not default value.', function () {

    $this->cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_REQUIRED,
        "The username",
        "defined default value"
    );


    $expected = "provided default value";
    mockGetOptToReturn(['user' => $expected]);

    $this->cli->arguments->parse();

    $actual = $this->cli->arguments->get('user');

    $this->assertEquals($expected, $actual);
});

test('Optional option with default value should use it if non provided.', function () {

    $expected = "defined password default value";

    $this->cli->arguments->addOption(
        'password',
        'p',
        Option::OPTION_OPTIONAL,
        "The password",
        $expected
    );

    $this->cli->arguments->parse();

    $actual = $this->cli->arguments->get('password');

    $this->assertEquals($expected, $actual);
});

test('Optional option should use provided value and not default value.', function () {

    $this->cli->arguments->addOption(
        'password',
        'p',
        Option::OPTION_OPTIONAL,
        "The password",
        "defined password default value"
    );


    $expected = "provided default value";
    mockGetOptToReturn(['password' => $expected]);

    $this->cli->arguments->parse();

    $actual = $this->cli->arguments->get('password');

    $this->assertEquals($expected, $actual);
});

test('Getting argument should return false if non provided.', function () {

    /**
     * Some fake argument. This option is defined, but
     * we don't emulate providing it.
     */
    $this->cli->arguments->addOption(
        'user',
        'p',
        Option::OPTION_OPTIONAL,
        "The username",
    );

    $this->cli->arguments->parse();

    /**
     * Should return false
     */
    $actual = $this->cli->arguments->get('user');

    $this->assertFalse($actual);
});

