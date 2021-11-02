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

test("Should be able to output short prefix", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "-u";
    $haystack = $this->cli->getOutputBuffer()->fetch();

    $this->assertStringContainsString($needle, $haystack);
});

test("Should be able to output long prefix", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "--username";
    $haystack = $this->cli->getOutputBuffer()->fetch();
    $this->cli->mute(true);

    $this->assertStringContainsString($needle, $haystack);
});

test("Should be able to output default value", function () {
    $this->cli->mute(true);
    $this->cli->arguments->usage();

    $needle = "default value here";
    $haystack = $this->cli->getOutputBuffer()->fetch();

    $this->assertStringContainsString($needle, $haystack);
});