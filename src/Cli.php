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

use Redbox\Cli\Arguments\Manager as ArgumentManager;
use Redbox\Cli\Output\Output;
use Redbox\Cli\Styling\Colors;
use Redbox\Cli\Terminal\Box;
use Redbox\Cli\Terminal\Progress;
use Redbox\Cli\Terminal\ProgressBar;

/**
 * The main class.
 * @method reset()
 */
class Cli
{
    /**
     * An instance of the Argument Manager class
     *
     * @var \Redbox\Cli\Arguments\Manager
     */
    public ArgumentManager $argumentManager;

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
        $this->setArgumentManager(new ArgumentManager());
        $this->router = new Router($this);
        $this->router->addManyRoutes(
            [
                new Colors(),
                new Terminal(),
                new ProgressBar(),
                new Box(),
            ]
        );

        $this->output = new Output();
    }

    /**
     * Set the manager for handling arguments
     *
     * @param \Redbox\Cli\Arguments\Manager $manager
     */
    public function setArgumentManager(ArgumentManager $manager)
    {
        $this->argumentManager = $manager;
    }

    /**
     * Return the argument manager.
     *
     * @return \Redbox\Cli\Arguments\Manager
     */
    public function getArgumentManager(): ArgumentManager
    {
        return $this->argumentManager;
    }

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