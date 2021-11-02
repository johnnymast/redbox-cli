<?php

require 'autoload.php';


use Redbox\Cli\Cli as Cli;
use \Redbox\Cli\Arguments\Option;


$cli = new Cli;


/**
 * Run this script like
 *
 * $ php ./basic.php -p=abc --user=abcd
 */
try {

    $cli->setDescription("Create apps with ease");

    $cli
        ->arguments
        ->registerOperation("customer", fn(\Redbox\Cli\Arguments\Operation $operation) => $operation
            ->registerOption(
                'Eek',
                'e',
                Option::OPTION_REQUIRED,
                "Shows eek the cat",
                "")
            ->registerOption(
                'help',
                'h',
                Option::OPTION_OPTIONAL,
                "Display help for the given command. When no command is given display help for the list command",
                "abc")
        );

        $cli->arguments
            ->registerOperation("sales", fn(\Redbox\Cli\Arguments\Operation $operation) => $operation
                ->registerOption(
                    'get',
                    null,
                    Option::OPTION_REQUIRED,
                    "Shows eek the cat",
                    "")
            );

    $operation = $cli->arguments->getOperation("customer");
    print_r($operation->getRequiredOptions());

    $cli->arguments->parse();


} catch (Exception $e) {
    /**
     * Print how to use the script
     */
    $cli->arguments->usage();
}


