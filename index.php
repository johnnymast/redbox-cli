<?php
require 'vendor/autoload.php';

use Redbox\Cli\Cli as CLI;

try {
    $cli = new CLI;
    $cli->arguments->add([
        'user' => [
            'prefix'       => 'u',
            'longPrefix'   => 'user',
            'description'  => 'Username',
            'defaultValue' => 'me_myself_i',
            'required'     => true,
        ],
        'password' => [
            'prefix'      => 'p',
            'longPrefix'  => 'password',
            'description' => 'Password',
            'required'    => true,
        ],
        'iterations' => [
            'prefix'      => 'i',
            'longPrefix'  => 'iterations',
            'description' => 'Number of iterations',
            'castTo'      => 'int',
        ],
        'verbose' => [
            'prefix'      => 'v',
            'longPrefix'  => 'verbose',
            'description' => 'Verbose output',
            'noValue'     => true,
        ],
        'help' => [
            'longPrefix'  => 'help',
            'description' => 'Prints a usage statement',
            'noValue'     => true,
        ],
        'path' => [
            'description' => 'The path to push',
        ],
    ]);
    $cli->arguments->parse();

    echo "You entered password: ".$cli->arguments->get('password')."\n";
    echo "You entered username: ".$cli->arguments->get('user')."\n";

} catch (Exception $e) {
    print_r($e);
    $cli->arguments->usage();
}


//$cli->arguments->debug();
echo 'hi';