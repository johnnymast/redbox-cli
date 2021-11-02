<?php
/**
 * Cli.php
 *
 * The main CLI class.
 *
 * PHP version ^8.0
 *
 * @category Core
 * @package  Redbox-Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  1.5
 * @link     https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md
 * @since    1.0
 */

namespace Redbox\Cli;

use JetBrains\PhpStorm\Pure;
use Redbox\Cli\Arguments\Arguments;
use Redbox\Cli\Output\Output;
use Redbox\Cli\Styling\Colors;
use Redbox\Cli\Terminal\Box;
use Redbox\Cli\Terminal\Progress;
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
     * @var \Redbox\Cli\Output\Output
     */
    protected Output $output;

    /**
     * The router.
     *
     * @var \Redbox\Cli\Router
     */
    protected Router $router;

    public function __construct()
    {

        $this->arguments = new Arguments(new Output());

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

        $this->output = new Output();

    }

    // NEw

    public function setDescription(string $description): Cli
    {
        $this->arguments->setDescription($description);
        return $this;
    }

    // eof new

    /**
     * Return the output renderer.
     *
     * @return \Redbox\Cli\Output\Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }

    /**
     * Write text to the cli.
     *
     * @param string $string The string to write.
     *
     * @return void
     */
    public function write(string $string)
    {
        $this->output->addLine($string);
        $this->output->output();
    }

    /**
     * Read the output, so it can use captured
     * in a variable.
     *
     * @return string
     */
    public function read(): string
    {
        return $this->output->fetch();
    }

    /**
     * Set silent mode. This means output can be fetched
     * into a variable.
     *
     * @param bool $enabled Mute enabled true/false
     *
     * @return void
     */
    public function mute(bool $enabled)
    {
        $this->output->setSilentMode($enabled);
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