<?php
require '../vendor/autoload.php';

use Redbox\Cli\Cli as CLI;

/**
 * Run this script like
 * $ php ./yourscript.php -p=abc --user=abcd
 */

try {
    $cli = new CLI;

    /**
     * Setup the rules of engagement
     */
    $cli->arguments->add([
        'targetpath' => [
            'prefix'       => 't',
            'longPrefix'   => 'targetpath',
            'description'  => 'Path',
            'defaultValue' => '/var/log',
            'required'     => true,
        ]
    ]);

    /**
     * We need to tell the parser to start.
     */
    $cli->arguments->parse();

    /**
     * If we dont get an exception of us missing things we can handle stuff.
     */
    echo "You entered path: ".$cli->arguments->get('targetpath')."\n";



} catch (Exception $e) {
    /**
     * Print how to use the script
     */
    $cli->arguments->usage();
}
