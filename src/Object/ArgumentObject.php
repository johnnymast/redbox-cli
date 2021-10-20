<?php
/**
 * ArgumentObject.php
 *
 * Object containing information about the arguments.
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

namespace Redbox\Cli\Object;

/**
 * class ArgumentObject
 */
class ArgumentObject
{

    /**
     * Container for storing information about
     * the argument.
     *
     * @var array
     */
    protected array $modelData = [];

    /**
     * Construct this magic object. Give it a array amd
     * it will turn into an object. It's a hydration.
     *
     * Object constructor.
     *
     * @param array $array Give the mapTypes a default empty value.
     */
    public function __construct(array $array = [])
    {
        $this->mapTypes($array);
    }

    /**
     * Convert a string to camelCase
     *
     * @param string $value Create a camelCase string from this value.
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
    protected function mapTypes(array $array = [])
    {
        foreach ($array as $key => $val) {
            if (!property_exists($this, $this->keyType($key)) &&
                property_exists($this, $key)) {
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
     * @param string  The type of the argument.
     *
     * @return string
     */
    protected function keyType(string $key): string
    {
        return $key . "Type";
    }

    /**
     * Return the dataType for a key.
     *
     * @param string $key Return a string name for the dataType.
     *
     * @return string
     */
    protected function dataType(string $key): string
    {
        return $key . "DataType";
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
     * @param string $key The key to unset.
     */
    public function __unset(string $key)
    {
        unset($this->modelData[$key]);
    }
}
