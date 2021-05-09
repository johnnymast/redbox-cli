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

namespace Redbox\Cli\Object;

/**
 * The base class for the Argument class.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class ArgumentObject
{

    /**
     * The parsed data for a argument.
     *
     * @var array
     */
    protected $modelData = [];

    /**
     * Construct this magic object. Give it a array amd
     * it will turn into an object. Its a hydration.
     *
     * Object constructor.
     *
     * @param array $array The options for the argument.
     */
    public function __construct($array = array())
    {
        $this->mapTypes($array);
    }

    /**
     * Convert a string to camelCase
     *
     * @param string $value The value to turn into camelCase.
     *
     * @return string
     */
    public static function camelCase(string $value): string
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        $value = str_replace(' ', '', $value);
        $value[0] = strtolower($value[0]);
        return $value;
    }

    /**
     * Initialize this object's properties from an array.
     *
     * @param array $array Used to seed this object's properties.
     *
     * @return void
     */
    protected function mapTypes(array $array): void
    {
        foreach ($array as $key => $val) {
            if (!property_exists($this, $this->keyType($key))
                && property_exists($this, $key)
            ) {
                $this->$key = $val;
                unset($array[$key]);
            } elseif (property_exists($this, $camelKey = self::camelCase($key))) {
                $this->$camelKey = $val;
            }
        }
        $this->modelData = $array;
    }

    /**
     * Return the keyType for a given key.
     *
     * @param string $key Return the type of the value.
     *
     * @return string
     */
    protected function keyType(string $key): string
    {
        return $key . "Type";
    }

    /**
     * Check to see if a given key is set or not.
     *
     * @param string $key The key to check.
     *
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return isset($this->modelData[$key]);
    }

    /**
     * Unset a given key.
     *
     * @param string $key The key value to unset.
     *
     * @return void
     */
    public function __unset(string $key): void
    {
        unset($this->modelData[$key]);
    }
}
