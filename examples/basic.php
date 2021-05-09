<?php
/**
 * Basic.php
 *
 * Run this script like
 *
 * $ php ./basic.php -p=abc --user=abcd
 *
 * PHP version 7.3 and up.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */

require 'autoload.php';

use Redbox\Cli\Cli as CLI;

/**
 * Run this script like
 *
 * $ php ./basic.php -p=abc --user=abcd
 */
try {
    $cli = new CLI;

    /**
     * Setup the rules of engagement
     */
    $cli->arguments->add(
        [
            'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'defaultValue' => 'me_myself_i',
                'required' => true,
            ],
            'password' => [
                'prefix' => 'p',
                'longPrefix' => 'password',
                'description' => 'Password',
                'required' => true,
            ],
            'iterations' => [
                'prefix' => 'i',
                'longPrefix' => 'iterations',
                'description' => 'Number of iterations',
            ],
            'verbose' => [
                'prefix' => 'v',
                'longPrefix' => 'verbose',
                'description' => 'Verbose output',
                'noValue' => true,
            ],
            'help' => [
                'longPrefix' => 'help',
                'description' => 'Prints a usage statement',
                'noValue' => true,
            ],
            'path' => [/* NOT YET SUPPORTED */
                       'description' => 'The path to push',
            ],
        ]
    );

    /**
     * We need to tell the parser to start.
     */
    $cli->arguments->parse();

    /**
     * If we don't get an exception of us missing things we can handle stuff.
     *
     * @scrutinizer ignore-type
     */
    echo "You entered password: " . $cli->arguments->get('password') . "\n";
    echo "You entered username: " . $cli->arguments->get('user') . "\n";

} catch (Exception $e) {
    /**
     * Print how to use the script
     */
    $cli->arguments->usage();
}
