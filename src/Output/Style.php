<?php

namespace Redbox\Cli\Output;

class Style
{
    protected array $styles = [];


    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->styles = [
            'foreground_color' => '',
            'background_color' => '',
            'font_style' => 'reset',
        ];
    }

    public function createClone()
    {
        return new $this;
    }

    public function withStyle(Style $style)
    {

        $new = $this->createClone();
        $styles = $style->getStyles();

        foreach ($styles as $key => $value) {
            $new->$key = $value;
        }

        return $new;
    }


    public function getStyles(): array
    {
        return $this->styles;
    }

    public function __set(string $name, $value): void
    {
        if (isset($this->styles[$name]) === true) {
            $this->styles[$name] = $value;
        }
    }

    public function __get(string $name)
    {
        if (isset($this->styles[$name]) === true) {
            return $this->styles[$name];
        }
    }

    private function from_camel_case($input)
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ?
                strtolower($match) :
                lcfirst($match);
        }
        return implode('_', $ret);
    }

    public function __call(string $name, array $arguments)
    {
        $action = substr(strtolower($name), 0, 3);
        $property = str_replace($action, '', $name);
        $property = $this->from_camel_case($property);

        if ($action === 'set') {
            if (isset($this->styles[$property]) == true) {
                return $this->styles[$property] = current($arguments);
            }
        } elseif ($action === 'get') {
            if (isset($this->styles[$property]) == true) {
                return $this->styles[$property];
            }
        }

        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}