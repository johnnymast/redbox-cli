<?php
/**
 * Manager.php
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

namespace Redbox\Cli\Arguments;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class Manager
{
    /**
     * An array of arguments passed to the program.
     *
     * @var array $arguments
     */
    protected $arguments = [];

    /**
     * An array containing the parsed values.
     *
     * @var array $values ;
     */
    protected $values = [];

    /**
     * An array that contains all the default values
     * that are passed to the manager.
     *
     * @var array
     */
    protected $defaultvalues = [];

    /**
     * An instance of the argument options parser.
     *
     * @var \Redbox\Cli\Arguments\Parser
     */
    protected $parser;

    /**
     * An instance of the argument options filter.
     *
     * @var \Redbox\Cli\Arguments\Filter
     */
    protected $filter;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->parser = new Parser($this);
        $this->filter = new Filter;
    }

    /**
     * Prints out the usage message to the user.
     *
     * @return void
     */
    public function usage(): void
    {
        $requiredArguments = $this->filter->required();
        $optionalArguments = $this->filter->optional();
        $allArguments = array_merge($requiredArguments, $optionalArguments);
        $command = $this->parser->getCommand();
        $args = array();

        $num_required = count($requiredArguments);
        $num_optional = count($optionalArguments);

        echo "Usage: " . $command . " ";

        foreach ($allArguments as $argument) {
            /**
             * Type of Argument.
             *
             * @var Argument $argument
             */
            $args[] = '[' . $argument->usageInfo() . ']';
        }

        $args = implode(' ', $args);
        echo $args . "\n\n";

        if ($num_required) {
            echo "Required Arguments:\n";
            foreach ($requiredArguments as $argument) {
                echo $argument->usageLine();
            }
        }

        if ($num_required && $num_optional) {
            echo "\n";
        }

        if ($num_optional) {
            echo "Optional Arguments:\n";
            foreach ($optionalArguments as $argument) {
                echo $argument->usageLine();
            }
        }

        echo "\n";
    }

    /**
     * Determine if a given argument has a default value or not.
     * One thing to note is that if having no info about the argument
     * (being a key in xx is not set) we will return false as well.
     *
     * @param string $argument The argument to check.
     *
     * @return boolean
     */
    public function hasDefaultValue(string $argument): bool
    {
        if (isset($this->defaultvalues[$argument]) === true) {
            return true;
        }
        return false;
    }

    /**
     * Set if a argument has defaulted to the default argument or not.
     *
     * @param string $argument The argument name.
     * @param bool   $default  The value to assign.
     *
     * @return void
     */
    public function setHasDefaultValue(string $argument = "", bool $default = false)
    {
        $this->defaultvalues[$argument] = $default;
    }

    /**
     * Get the default value for a argument.
     *
     * @param string $argument The argument key
     *
     * @return mixed
     */
    public function getDefaultValue(string $argument)
    {
        if ($this->hasDefaultValue($argument)) {
            return $this->get($argument);
        }

        return false;
    }

    /**
     * Check to see if a argument is used.
     *
     * @param string $argument The name of the argument.
     *
     * @return bool
     */
    public function has(string $argument): bool
    {
        return (isset($this->values[$argument]));
    }

    /**
     * Set a parsed argument.
     *
     * @param string $argument The argument name.
     * @param mixed  $value    The argument value.
     *
     * @return void
     */
    public function set(string $argument, $value): void
    {
        $this->values[$argument] = $value;
    }

    /**
     * Return any set argument or false if the argument is unknown.
     *
     * @param string $argument The name of the argument.
     *
     * @return mixed
     */
    public function get(string $argument)
    {
        if (isset($this->values[$argument]) === false) {
            return false;
        }
        return $this->values[$argument];
    }

    /**
     * Return all given arguments.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->arguments;
    }

    /**
     * This function will be called if we can add an array of commandline arguments
     * to parse.
     *
     * @param array $arguments The argument options.
     *
     * @return void
     * @throws \Exception
     */
    protected function addMany(array $arguments = []): void
    {
        foreach ($arguments as $name => $options) {
            $this->add($name, $options);
        }
    }

    /**
     * Add arguments to the list, this could be one or an array of arguments.
     *
     * @param $argument The argument name.
     * @param array $options  The argument options.
     *
     * @return void
     * @throws \Exception
     */
    public function add($argument, $options = []): void
    {
        if (is_array($argument) === true) {
            $this->addMany($argument);
            return;
        }

        $options['name'] = $argument;
        $arg = new Argument($options);

        $this->arguments[$argument] = $arg;
    }

    /**
     * Go ahead and parse the arguments given.
     *
     * @return void
     * @throws \Exception
     */
    public function parse(): void
    {
        $this->parser->setFilter($this->filter, $this->all());
        $this->parser->parse();
    }
}
