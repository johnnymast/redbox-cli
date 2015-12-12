<?php
namespace Redbox\Cli\Tests;


/**
 * Created by PhpStorm.
 * User: johnny
 * Date: 12-12-15
 * Time: 16:51
 */
class ArgumentsTest extends TestBase
{
    public function testRequiredArgumentIsNotFound() {
        $rules = array([
            'user' => [
                'prefix'       => 'u',
                'longPrefix'   => 'user',
                'description'  => 'Username',
                'defaultValue' => 'me_myself_i',
                'required'     => true,
            ]
        ]);

        $argv = array(
            $arg[0],
        );

        /**
         * We need to tell the parser to start.
         */
        $this->cli->arguments->parse();
    }
}
