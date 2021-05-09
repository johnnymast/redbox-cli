<?php
/**
 * OverwriteGetOpt.php
 *
 * PHP version 7.3 and up.
 *
 * @category Tests
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */

namespace Redbox\Cli\Arguments;

/**
 * Class OptValue
 *
 * @package Redbox\Cli\Arguments
 */
class OptValue
{
    /**
     * The value for getopt.
     *
     * @var
     */
    public static $value;

    /**
     * Set a value.
     *
     * @param mixed $value The value to set.
     *
     * @return void
     */
    public static function setValue($value): void
    {
        self::$value = $value;
    }

    /**
     * Return the value.
     *
     * @return mixed
     */
    public static function getValue()
    {
        return self::$value;
    }
}

/**
 * Overwrite the getopt namespace for the Redbox\Cli\Arguments
 * namespace.
 *
 * @param $short_options Each character in this string will be used as option characters and
 *                       matched against options passed to the script starting with a single
 * @param array|null $long_options  An array of options. Each element in this array will be used as option
 *                                  strings and matched against options passed to the script starting with
 * @param int|null   $rest_index    If the optind parameter is present, then the index where argument parsing stopped
 *                                  will be written to this variable.
 *
 * @return false|false[]|string[]
 */
function getopt($short_options, array $long_options = null, int &$rest_index = null)
{
    return OptValue::getValue() ?: \getopt($short_options, $long_options, $rest_index);
}

/**
 * Make getopt to return a given value.
 *
 * @param $info Make getopt return this value.
 *
 * @return void
 */
function mockGetOptToReturn($info): void
{
    OptValue::setValue($info);
}

/**
 * Reset the mock.
 *
 * @return void
 */
function resetGetOptMock(): void
{
    OptValue::setValue(null);
}
