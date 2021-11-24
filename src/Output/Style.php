<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Output;

/**
 * @method setForegroundColor(string $color);
 * @method setBackgroundColor(string $color);
 * @method setFontStyle(string $style);
 *
 * @method getForegroundColor();
 * @method getBackgroundColor();
 * @method getFontStyle();
 *
 *
 * @internal
 */
class Style
{
    /**
     * Container for the styles.
     *
     * @var array<string, string>
     */
    protected array $styles = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Reset the styles.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->styles = [
            'foreground_color' => '',
            'background_color' => '',
            'font_style' => 'reset',
        ];
    }

    /**
     * Create a new clone of the Style
     * object.
     *
     * @return \Redbox\Cli\Output\Style
     */
    public function createClone(): Style
    {
        return new $this;
    }

    /**
     * Create a new style from an existing style.
     *
     * @param \Redbox\Cli\Output\Style $style The style to clone.
     *
     * @return \Redbox\Cli\Output\Style
     */
    public function withStyle(Style $style): Style
    {

        $new = $this->createClone();
        $styles = $style->getStyles();

        foreach ($styles as $key => $value) {
            $new->$key = $value;
        }

        return $new;
    }

    /**
     * Return the styles.
     *
     * @return array<string, string>
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * Set value of a style field.
     *
     * @param string $name  The field name to set.
     * @param string $value The field value to set.
     *
     * @return void
     */
    public function __set(string $name, string $value): void
    {
        if (isset($this->styles[$name]) === true) {
            $this->styles[$name] = $value;
        }
    }

    /**
     * Check if a field has been set.
     *
     * @param string $name The field name to check.
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return (isset($this->styles[$name]));
    }

    /**
     * Return a style field.
     *
     * @param string $name The style name to return.
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if (isset($this->styles[$name]) === true) {
            return $this->styles[$name];
        }

        return null;
    }

    /**
     * Transform a Camelcase string from camel case to Snakecase.
     *
     * @param string $input The string to convert.
     *
     * @return string
     */
    private function from_camel_case(string $input): string
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = ($match === strtoupper($match)) ?
                strtolower($match) :
                lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * Bind style to magic methods.
     *
     * @param string  $name      The method name.
     * @param array<string> $arguments The method arguments.
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        $action = strtolower(substr($name, 0, 3));
        $property = str_replace($action, '', $name);
        $property = $this->from_camel_case($property);


        if ($action === 'set') {
            if (isset($this->styles[$property]) === true) {
                return $this->styles[$property] = current($arguments);
            }
        } elseif ($action === 'get') {
            if (isset($this->styles[$property]) === true) {
                return $this->styles[$property];
            }
        }
        echo "PROPERTY: {$property}\n";

        return trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}