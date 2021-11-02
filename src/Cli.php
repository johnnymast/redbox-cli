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

use JetBrains\PhpStorm\Pure;
use Redbox\Cli\Arguments\Arguments;
use Redbox\Cli\Output\OutputBuffer;
use Redbox\Cli\Styling\Colors;
use Redbox\Cli\Terminal\Box;
use Redbox\Cli\Terminal\ProgressBar;
use Redbox\Cli\Terminal\Table;

#[Pure]
/**
 * The main class.
 * @method reset()
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
     * @var \Redbox\Cli\Router
     */
    protected Router $router;

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->outputBuffer = new OutputBuffer();
        $this->arguments = new Arguments( $this->outputBuffer);

        $this->router = new Router($this);
        $this->router->addManyRoutes(
            [
                new Colors(),
                new Terminal(),
                new ProgressBar(),
                new Box(),
                new Table(),
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
     * @param array  $arguments The arguments.
     *
     * @return \Redbox\Cli\Cli|void
     */
    public function __call(string $name, array $arguments): ?Cli
    {
        if ($this->router->hasRoute($name) === true) {
            return $this->router->execute($name, $arguments);
        }

        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}