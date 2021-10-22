<?php
/**
 * Argument.php
 *
 * The main class for handling arguments.
 *
 * PHP version ^8.0
 *
 * @category Arguments
 * @package  Redbox-Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  1.5
 * @link     https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md
 * @since    1.0
 */

namespace Redbox\Cli\Arguments\old;

use Redbox\Cli\Object\ArgumentObject;

/**
 * The Argument class represents one single argument
 * set to the Arguments. To make sure its universal we use
 * the ArgumentObject as an abstract to this class.
 *
 * @package Redbox\Cli\Arguments
 */
class Argument extends ArgumentObject
{
    const LINE_FMT = "\t%s\n\t\t%s\n";

    public string $prefix = '';
    public string $defaultValue = '';
    public string $longPrefix = '';
    public string $description = '';
    public bool $required = false;
    public string $name = '';

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
        return implode(', ', $arg);
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
        return sprintf(self::LINE_FMT, $this->usageInfo(), $this->description);
    }
}