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

/**
 * @class Redbox\Cli\Arguments\Operation
 */
class Option
{
    public const OPTION_REQUIRED = 0;
    public const OPTION_OPTIONAL = 1;
    public const OPTION_NOVALUE = 2;

    private const LINE_FMT = "%s\t\t%s\n";

    public string $longPrefix = '';

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
    public function hasDefault(): bool
    {
        return ($this->default and $this->default !== '');
    }

    /**
     * Return the default value.
     */
    public function getDefaultValue(): string {
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
    public function usageInfo(array $arg = []): string
    {

//        -h, --help            Display help for the given command. When no command is given display help for the list command
//    -q, --quiet           Do not output any message
//    -V, --version         Display this application version
//    --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
//    -n, --no-interaction  Do not ask any interactive question
//    -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
//
//
        if ($this->prefix) {
            $arg[] = '-' . $this->prefix;
        }
//        if ($this->name) {
        $arg[] = '--' . $this->name . '=' . $this->name;
//        }
        if ($this->default) {
            $arg[] = '(default: ' . $this->default . ')';
        }
//        if (!$this->prefix && !$this->longPrefix) {
        //   $arg[] = $this->name;
//        }
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