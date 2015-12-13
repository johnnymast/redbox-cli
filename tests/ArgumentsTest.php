<?php
namespace Redbox\Cli\Tests;
use Redbox\Cli\Cli;


/**
 * Created by PhpStorm.
 * User: johnny
 * Date: 12-12-15
 * Time: 16:51
 */
class ArgumentsTest extends TestBase
{
    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage The following arguments are required: user.
     */
    public function testRequiredArgumentIsNotFound()
    {

       /**
         * This test will fail because the test didn't set the require -u or --user
         * argument.
         *
         */
        global $argv;
        $argv = array(
            self::OUR_APP,
        );

        $cli = new Cli();
        $cli->arguments->add([
            'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'required' => true,
            ]
        ]);

        $cli->arguments->parse();
    }
}
