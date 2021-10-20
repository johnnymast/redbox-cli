<?php
require 'autoload.php';

use Redbox\Cli\Cli as CLI;

/**
 * Run this script like
 *
 * $ php ./hasdefaultvalue.php
 * OR
 * $ php ./hasdefaultvalue.php --targetpath=/var
 */
try {
    $cli = new CLI;

    /**
     * Setup the rules of engagement
     */
    $cli->argumentManager->add([
        'targetpath' => [
            'prefix'       => 't',
            'longPrefix'   => 'targetpath',
            'description'  => 'Path',
            'defaultValue' => '/var/log',
        ]
    ]);

    /**
     * We need to tell the parser to start.
     */
    $cli->argumentManager->parse();

    /**
     * If we don't get an exception of us missing things we can handle stuff.
     */
    echo "You entered path: ".$cli->argumentManager->get('targetpath')."\n";
    echo "Is this the default value?: ".($cli->argumentManager->hasDefaultValue('targetpath') ? 'Yes' : 'No')."\n";

} catch (Exception $e) {
    /**
     * Print how to use the script
     */
    $cli->argumentManager->usage();
}
