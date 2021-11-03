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
    ->beforeEach(function () {
        $this->operation = new Operation("Test Operation");
    })
    ->group('arguments');


test("All constructor values should persist.", function () {
    $option = new Option(
        $this->operation,
        "constructor_test",
        "p",
        Option::OPTION_REQUIRED,
        "description",
        "default value"
    );

    $expected = "constructor_test";
    $actual = $option->name;
    $this->assertEquals($expected, $actual);

    $expected = "p";
    $actual = $option->prefix;
    $this->assertEquals($expected, $actual);

    $expected = Option::OPTION_REQUIRED;
    $actual = $option->options;
    $this->assertEquals($expected, $actual);

    $expected = "description";
    $actual = $option->description;
    $this->assertEquals($expected, $actual);

    $expected = "default value";
    $actual = $option->default;
    $this->assertEquals($expected, $actual);

    $expected = "constructor_test";
    $actual = $option->longPrefix;
    $this->assertEquals($expected, $actual);
});

test("Should know if option is required.", function () {
    $option1 = new Option(
        $this->operation,
        "required1",
        "o1",
        Option::OPTION_OPTIONAL,
        "description",
        "default value"
    );

    $option2 = new Option(
        $this->operation,
        "required2",
        "o2",
        Option::OPTION_REQUIRED,
        "description"
    );

    $expected = false;
    $actual = $option1->isRequired();
    $this->assertEquals($actual, $expected);

    $expected = true;
    $actual = $option2->isRequired();
    $this->assertEquals($actual, $expected);
});

test("Should know if option is optional.", function () {
    $option1 = new Option(
        $this->operation,
        "optional1",
        "o1",
        Option::OPTION_REQUIRED,
        "description",
        "default value"
    );

    $option2 = new Option(
        $this->operation,
        "optional2",
        "o2",
        Option::OPTION_OPTIONAL,
        "description"
    );

    $expected = false;
    $actual = $option1->isOptional();
    $this->assertEquals($actual, $expected);

    $expected = true;
    $actual = $option2->isOptional();
    $this->assertEquals($actual, $expected);
});

test("Should know if option requires no value.", function () {
    $option1 = new Option(
        $this->operation,
        "novalue1",
        "n1",
        Option::OPTION_REQUIRED,
        "description",
        "default value"
    );

    $option2 = new Option(
        $this->operation,
        "novalue2",
        "n2",
        Option::OPTION_NO_VALUE,
        "description"
    );

    $expected = false;
    $actual = $option1->isNoValue();
    $this->assertEquals($actual, $expected);

    $expected = true;
    $actual = $option2->isNoValue();
    $this->assertEquals($actual, $expected);
});

test("Should know if option has a short prefix.", function () {
    $option = new Option(
        $this->operation,
        "prefix_test",
        "p",
        Option::OPTION_REQUIRED,
    );

    $expected = true;
    $actual = $option->hasShortPrefix();
    $this->assertEquals($actual, $expected);

    $expected = "p";
    $actual = $option->prefix;
    $this->assertEquals($actual, $expected);
});

test("Should know if option has a default value.", function () {

    $option1 = new Option(
        $this->operation,
        "option1",
        "o1",
        Option::OPTION_REQUIRED,
        "description",
        "default value"
    );

    $option2 = new Option(
        $this->operation,
        "option2",
        "o2",
        Option::OPTION_REQUIRED,
        "description"
    );

    $expected = true;
    $actual = $option1->hasDefaultValue();
    $this->assertEquals($actual, $expected);

    $expected = false;
    $actual = $option2->hasDefaultValue();
    $this->assertEquals($actual, $expected);
});

test("Should have a reverence to its Operation.", function () {
    $option = new Option(
        $this->operation,
        "username",
        "n",
        Option::OPTION_REQUIRED,
        "description",
        "default value"
    );

    $expected = $this->operation;
    $actual = $option->getOperation();

    $this->assertEquals($actual, $expected);
});