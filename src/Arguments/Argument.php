<?php
/**
 * Argument.php
 *
 * PHP version 7.3 and up.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/mysql_websocket_chat
 * @since    1.5
 */

namespace Redbox\Cli\Arguments;

use Redbox\Cli\Object\ArgumentObject;

/**
 * The Argument class represents one single argument
 * set to the Manager. To make sure its universal we use
 * the ArgumentObject as an abstract to this class.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class Argument extends ArgumentObject
{
    const LINE_FMT = "\t%s\n\t\t%s\n";

    public $prefix;
    public $defaultValue;
    public $longPrefix;
    public $description;
    public $required;
    public $name;

    /**
     * Returns the usage information for this argument something like
     * -u user, --user user, (default: me_myself_i)
     *
     * @return string
     */
    public function usageInfo(): string
    {
        $arg = array();
        if ($this->prefix) {
            $arg[] = '-' . $this->prefix . ' ' . $this->name;
        }
        if ($this->longPrefix) {
            $arg[] = '--' . $this->longPrefix . ' ' . $this->name;
        }
        if ($this->defaultValue) {
            $arg[] = '(default: ' . $this->defaultValue . ')';
        }
        if (!$this->prefix && !$this->longPrefix) {
            $arg[] = $this->name;
        }
        $arg = implode(', ', $arg);
        return $arg;
    }

    /**
     * Returns a usage line something like.
     * -u user, --user user, (default: me_myself_i)
     *   Username
     *
     * @return string
     */
    public function usageLine(): string
    {
        $arg = $this->usageInfo();
        return sprintf(self::LINE_FMT, $arg, $this->description);
    }
}