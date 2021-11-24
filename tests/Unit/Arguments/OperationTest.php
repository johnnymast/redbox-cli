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

use Redbox\Cli\Arguments\Operation;
use Redbox\Cli\Arguments\Option;

uses()
    ->group('arguments');



test('Should know if it has any options.', function() {
    $operation = new Operation("some operation");

    $expected = false;
    $actual = $operation->hasOptions();

    $this->assertEquals($expected, $actual);

    $operation->addOption(
        'username',
        'u',
        Option::OPTION_REQUIRED,
        "The username",
    );

    $expected = true;
    $actual = $operation->hasOptions();

    $this->assertEquals($expected, $actual);
});

test("Show be able to return options with short prefix.", function() {
    $operation = new Operation("short prefix operation");

    $operation->addOption(
        'shortprefix',
        's',
        Option::OPTION_REQUIRED,
        "The short prefix",
    );

    $operation->addOption(
        'longPrefix',
        null,
        Option::OPTION_REQUIRED,
        "The long prefix",
    );

    $expected = 1;
    $actual = count($operation->getOptionsWithShortPrefix());
    $this->assertEquals($expected, $actual);

});

test("Show be able to return options with long prefix.", function() {
    $operation = new Operation("long prefix operation");

    $operation->addOption(
        'shortprefix',
        's',
        Option::OPTION_REQUIRED,
        "The short prefix",
    );

    $operation->addOption(
        'shortprefix2',
        's2',
        Option::OPTION_REQUIRED,
        "The short prefix2",
    );

    $operation->addOption(
        'longPrefix',
        null,
        Option::OPTION_REQUIRED,
        "The long prefix",
    );

    $expected = 2;
    $actual = count($operation->getOptionsWithLongPrefix());
    $this->assertEquals($expected, $actual);
});

test("Show be able to return required options.", function() {
    $operation = new Operation("required option operation");

    $operation->addOption(
        'required option1',
        's',
        Option::OPTION_REQUIRED,
        "The short prefix",
    );

    $operation->addOption(
        'required option2',
        's2',
        Option::OPTION_REQUIRED,
        "The short prefix2",
    );

    $operation->addOption(
        'optional',
        "o",
        Option::OPTION_OPTIONAL,
        "The optional option",
    );

    $expected = 2;
    $actual = count($operation->getRequiredOptions());
    $this->assertEquals($expected, $actual);
});

test("Show be able to return optional options.", function() {
    $operation = new Operation("required option operation");

    $operation->addOption(
        'required option1',
        's',
        Option::OPTION_REQUIRED,
        "The short prefix",
    );

    $operation->addOption(
        'required option2',
        's2',
        Option::OPTION_OPTIONAL,
        "The short prefix2",
    );

    $operation->addOption(
        'optional1',
        "o2",
        Option::OPTION_OPTIONAL,
        "The optional option2",
    );

    $expected = 2;
    $actual = count($operation->getOptionalOptions());
    $this->assertEquals($expected, $actual);
});

test("Show be able to return all options.", function() {
    $operation = new Operation("all options test");

    $operation->addOption(
        'test1',
        't1',
        Option::OPTION_REQUIRED,
        "Test1",
    );

    $operation->addOption(
        'test2',
        't2',
        Option::OPTION_REQUIRED,
        "Test2",
    );

    $operation->addOption(
        'test3',
        't3',
        Option::OPTION_REQUIRED,
        "Test3",
    );

    $expected = 3;
    $actual = count($operation->getOptions());
    $this->assertEquals($expected, $actual);
});

test("Show be able to be marked as default.", function() {
    $operation = new Operation("default test operation");

    $expected = false;
    $actual = $operation->isDefaultOperation();
    $this->assertEquals($expected, $actual);

    $operation->markAsDefault();

    $expected = true;
    $actual = $operation->isDefaultOperation();
    $this->assertEquals($expected, $actual);
});