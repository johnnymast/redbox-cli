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
    $cli->setDescription("My awesome ftp client.");

    $cli->arguments->addOption("name",
    'n',
        Option::OPTION_OPTIONAL,
        'Desc'
    );

    $cli->arguments->registerOperation("download")
        ->addOption(
            'user',
            'u',
            Option::OPTION_REQUIRED,
            "Username to log in with."
        )
        ->addOption(
            'password',
            'p',
            Option::OPTION_REQUIRED,
            "Password to login with"
        )
        ->addOption(
            'remove-file',
            'r',
            Option::OPTION_REQUIRED,
            "The file to download."
        )
        ->addOption(
            'local-file',
            'f',
            Option::OPTION_REQUIRED,
            "Save the file here."
        );


    $cli->arguments->registerOperation("upload")
        ->addOption(
            'user',
            'u',
            Option::OPTION_REQUIRED,
            "Username to log in with."
        )
        ->addOption(
            'password',
            'p',
            Option::OPTION_REQUIRED,
            "Password to login with"
        )
        ->addOption(
            'local-file',
            'f',
            Option::OPTION_REQUIRED,
            "The file to upload."
        );


    $cli->arguments->parse();

} catch (\Exception) {
    $cli->arguments->usage();
}