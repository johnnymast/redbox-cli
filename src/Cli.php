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

/**
 * The main class.
 */
class Cli
{
    /**
     * An instance of the Argument Manager class
     *
     * @var \Redbox\Cli\Arguments\Manager
     */
    public $arguments;

    public function __construct()
    {
        $this->setManager(new ArgumentManager());
    }

    /**
     * Set the manager for handling arguments
     *
     * @param \Redbox\Cli\Arguments\Manager $manager
     */
    public function setManager(ArgumentManager $manager)
    {
        $this->arguments = $manager;
    }
}