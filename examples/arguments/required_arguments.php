<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This example will show you how you can show
 * a usage screen that informs your users on
 * how to use your software.
 */

require __DIR__ . '/../autoload.php';

use Redbox\Cli\Arguments\Option;
use Redbox\Cli\Cli;

$cli = new Cli;

try {

    /**
     * This is optional.
     */
    $cli->setDescription("Showcase of required arguments.");

    /**
     * Add an option that we can show.
     */
    $cli->arguments->addOption(
        'user',
        'u',
        Option::OPTION_REQUIRED,
        "Username to log in with.");

    $cli->arguments->parse();

    $user = $cli->arguments->get('user');

    echo "Provided username: {$user}\n";

} catch (\Exception) {
    $cli->arguments->usage();
}