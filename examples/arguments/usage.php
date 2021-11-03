<?php
/**
 * This example will show you how you can show
 * a usage screen that informs your users on
 * how to use your software.
 */

require __DIR__ . '/../autoload.php';

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

$cli->arguments->usage();

/**
 * Output:
 *
 * usage.php - Showcase of the usage function.
 *
 * usage: usage.php default [-u, --user=user]
 *
 * Options:
 *
 * usage.php default -u, --User=User       Username to log in with.
 */