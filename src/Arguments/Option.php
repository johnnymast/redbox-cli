<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Arguments;

class Option
{
    /**
     * Using this flag means the option
     * is required.
     */
    public const OPTION_REQUIRED = 0;

    /**
     * Using this flag means this option
     * is not required.
     */
    public const OPTION_OPTIONAL = 1;

    /**
     * Using this flag means the option has no
     * default value and is used as initiator.
     */
    public const OPTION_NO_VALUE = 2;

    /**
     * The formatter for the line output.
     *
     * @see Option::usageLine()
     */
    private const LINE_FMT = "%s\t\t%s\n";

    /**
     * The long prefix for this option.
     *
     * @var string
     */
    public string $longPrefix = '';

    /**
     * @param \Redbox\Cli\Arguments\Operation $operation   The operation this option belongs to.
     * @param string                          $name        The name of this option.
     * @param string|null                     $prefix       The short prefix for this option.
     * @param int|null                        $options     The option flags for this option.
     * @param string                          $description The description for the usage output.
     * @param string|null                     $default     The default value for this option.
     */
    public function __construct(
        protected Operation $operation,
        public string       $name,
        public string|null  $prefix,
        public int|null     $options = null,
        public string       $description = '',
        public string|null  $default = null
    )
    {
        $this->longPrefix = $name;
    }

    /**
     * Check to see if this option is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return ($this->options === self::OPTION_REQUIRED);
    }

    /**
     * Check to see if this option is optional.
     *
     * @return bool
     */
    public function isOptional(): bool
    {
        return ($this->options === self::OPTION_OPTIONAL);
    }

    /**
     * Check to see if this option does not require a value.
     *
     * @return bool
     */
    public function isNoValue(): bool
    {
        return ($this->options === self::OPTION_NO_VALUE);
    }

    /**
     * Check to see if this option has a short prefix.
     *
     * @return bool
     */
    public function hasShortPrefix(): bool
    {
        return ($this->prefix and $this->prefix !== '');
    }

    /**
     * Check to see if this option has a short prefix.
     *
     * @return bool
     */
    public function hasLongPrefix(): bool
    {
        return ($this->name and $this->name !== '');
    }

    /**
     * Check to see if this option has a default value.
     *
     * @return bool
     */
    public function hasDefaultValue(): bool
    {
        return ($this->default and $this->default !== null);
    }

    /**
     * Return the default value.
     */
    public function getDefaultValue(): string
    {
        return $this->default;
    }

    /**
     * Return the operation this option belongs to.
     *
     * @return \Redbox\Cli\Arguments\Operation
     */
    public function getOperation(): Operation
    {
        return $this->operation;
    }

    /**
     * Returns the usage information for this argument something like
     * -u user, --user user, (default: me_myself_i)
     *
     * @return string
     */
    public function usageInfo(): string
    {

        $line = [];

        if ($this->prefix) {
            $line[] = '-' . $this->prefix;
        }

        $line[] = '--' . $this->name . '=' . $this->name;

        if ($this->default) {
            $line[] = '(default: ' . $this->default . ')';
        }

        return implode(', ', $line);
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