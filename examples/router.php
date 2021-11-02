<?php
require 'autoload.php';

use Redbox\Cli\Cli as CLI;


/**
 * Run this script like
 *
 * $ php ./basic.php -p=abc --user=abcd
 */
try {


    $cli = new CLI;
    $cli->black()
        ->redBackground()
        ->mute(true);
//        ->write("Test");

    $max = 100;
    $min = 0;
    $current = $min;

    $cli->box(
        1,
        $max,
        "Hello World",
        "*",
        "center"
    );

    $cli->reset()
        ->mute(false);

    $banner = $cli->read();

    echo $banner;

    $cli->write("\u{1F609}\n");


    for (; $current < $max+1; $current++) {
        $cli->progress($current, $max);
        sleep(0.5);
    }


} catch (Exception $e) {

}
