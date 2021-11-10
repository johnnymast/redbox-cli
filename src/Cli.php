<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli;

use Redbox\Cli\Arguments\Arguments;
use Redbox\Cli\Output\OutputBuffer;
use Redbox\Cli\Router\Router;
use Redbox\Cli\Styling\Colors;
use Redbox\Cli\Terminal\Box;
use Redbox\Cli\Terminal\ProgressBar;
use Redbox\Cli\Terminal\Table;

/**
 * The main class.
 * @method \Redbox\Cli\Output\OutputBuffer reset()
 * @method \Redbox\Cli\Output\OutputBuffer black(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer blackBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer red(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer redBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer green(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer greenBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer yellow(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer yellowBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer blue(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer blueBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer magenta(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer magentaBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer cyan(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer cyanBackground(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer white(string $string = '')
 * @method \Redbox\Cli\Output\OutputBuffer whiteBackground(string $string = '')
 *
 */
class Cli
{
    /**
     * An instance of the Argument Arguments class
     *
     * @var \Redbox\Cli\Arguments\Arguments
     */
    public Arguments $arguments;

    /**
     * This is the output buffer.
     *
     * @var \Redbox\Cli\Output\OutputBuffer
     */
    protected OutputBuffer $outputBuffer;

    /**
     * The router.
     *
     * @var \Redbox\Cli\Router\Router
     */
    protected Router $router;

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct()
    {
        $this->outputBuffer = new OutputBuffer();
        $this->arguments = new Arguments( $this->outputBuffer);

        $this->router = new Router($this);
        $this->router->addManyRoutes(
            [
                new Colors(),
            ]
        );
    }

    public function setDescription(string $description): Cli
    {
        $this->arguments->setDescription($description);
        return $this;
    }

    /**
     * Return the output renderer.
     *
     * @return \Redbox\Cli\Output\OutputBuffer
     */
    public function getOutputBuffer(): OutputBuffer
    {
        return $this->outputBuffer;
    }

    /**
     * Write text to the cli.
     *
     * @param string $string The string to write.
     *
     * @return void
     */
    public function write(string $string): void
    {
        $this->outputBuffer->addLine($string);
        $this->outputBuffer->show();
    }

    /**
     * Read the output, so it can use captured
     * in a variable.
     *
     * @return string
     */
    public function read(): string
    {
        return $this->outputBuffer->fetch();
    }

    /**
     * Set silent mode. This means output can be fetched
     * into a variable.
     *
     * @param bool $enabled Mute enabled true/false
     *
     * @return void
     */
    public function mute(bool $enabled): void
    {
        $this->outputBuffer->setSilentMode($enabled);
    }

    /**
     *
     * @param string $name      The method name.
     * @param array<string>  $arguments The arguments.
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($this->router->hasRoute($name) === true) {
            return $this->router->execute($name, $arguments);
        }

        return trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}