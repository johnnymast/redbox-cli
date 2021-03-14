<?php

namespace Redbox\Cli\Arguments;

/**
 * Class OptValue
 *
 * @package Redbox\Cli\Arguments
 */
class OptValue
{
    public static $value;
    
    public static function setValue($value)
    {
        self::$value = $value;
    }
    
    public static function getValue()
    {
        return self::$value;
    }
}

/**
 * @param              $short_options
 * @param  array|null  $long_options
 * @param  null        $rest_index
 *
 * @return false|false[]|string[]
 */
function getopt($short_options, array $long_options = null, &$rest_index = null)
{
    return OptValue::getValue() ?: \getopt($short_options, $long_options, $rest_index);
}

/**
 * @param $info
 */
function mockGetOptToReturn($info)
{
    OptValue::setValue($info);
}

/**
 * Reset thee mock
 */
function resetGetOptMock()
{
    OptValue::setValue(null);
}