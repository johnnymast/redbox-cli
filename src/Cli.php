<?php
/**
 * Cli.php
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

namespace Redbox\Cli;

use Redbox\Cli\Arguments\Manager as ArgumentManager;

/**
 * Class Cli
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class Cli
{
    /**
     * An instance of the Argument Manager class
     *
     * @var \Redbox\Cli\Arguments\Manager
     */
    public $arguments;

    /**
     * Cli constructor.
     */
    public function __construct()
    {
        $this->setManager(new ArgumentManager());
    }

    /**
     * Set the manager for handling arguments
     *
     * @param \Redbox\Cli\Arguments\Manager $manager The argument manager.
     *
     * @return void
     */
    public function setManager(ArgumentManager $manager): void
    {
        $this->arguments = $manager;
    }
}