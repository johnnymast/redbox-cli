<?php
namespace Redbox\Cli\Object;

class Object {

    protected $modelData = array();
    protected $processed = array();

    public function __construct($array)
    {
        $this->mapTypes($array);
    }

    /**
     * Convert a string to camelCase
     * @param  string $value
     * @return string
     */
    public static function camelCase($value)
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
     * @return void
     */
    protected function mapTypes($array)
    {

        // Hard initialise simple types, lazy load more complex ones.
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

    protected function keyType($key)
    {
        return $key."Type";
    }

    protected function dataType($key)
    {
        return $key."DataType";
    }

    public function __isset($key)
    {
        return isset($this->modelData[$key]);
    }

    public function __unset($key)
    {
        unset($this->modelData[$key]);
    }
}
