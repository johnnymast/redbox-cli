<?php
/**
 * This example will show you can read
 * the input given from the command line.
 */

require __DIR__ . '/../autoload.php';

/**
 * Run this example with argument -u=johnny
 */
use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

/**
 * This is optional.
 */
$cli->setDescription("Showcase of the usage function.");

/**
 * Add an option that we can show.
 */
$cli->arguments->addOption(
    'user',
    'u',
    Option::OPTION_OPTIONAL,
    "Username to log in with.");

$cli->arguments->parse();
$user = $cli->arguments->get("user");

echo "You provided username {$user}\n";

