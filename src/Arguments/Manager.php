<?php
namespace Redbox\Cli\Arguments;

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
     * @var array $values;
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $defaultvalues = [];

    /**
     * @var \Redbox\Cli\Arguments\Parser $parser;
     */
    protected $parser;

    /**
     * @var \Redbox\Cli\Arguments\Filter $filter;
     */
    protected $filter;

    public function __construct()
    {
        $this->parser = new Parser($this);
        $this->filter = new Filter;
    }

    /**
     * Prints out the usage message to the user.
     * @eturn void
     */
    public function usage() {
        $requiredArguments = $this->filter->required();
        $optionalArguments = $this->filter->optional();
        $allArguments      = array_merge($requiredArguments, $optionalArguments);
        $command           = $this->parser->getCommand();

        echo "Usage: ".$command;
        $args = array();
        foreach ($allArguments as $argument) {
            $args[] = '['.$argument->usageInfo().']';
        }
        $args = implode(' ', $args);
        echo $args."\n\n";

        if (count($requiredArguments) > 0) {
            echo "Required Arguments:\n";
            foreach ($requiredArguments as $argument) {
                echo $argument->usageLine();
            }
        }
        if (count($requiredArguments) && count($optionalArguments)) {
            echo "\n";
        }

        if (count($optionalArguments) > 0) {
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
     * @param $argument
     * @return boolean
     */
    public function hasDefaultValue($argument) {
        if (isset($this->defaultvalues[$argument]) === true) {
            return true;
        }
        return false;
    }

    /**
     * Set if a argument has defaulted to the default argument or not.
     *
     * @param string $argument
     * @param bool $default
     */
    public function setHasDefaultValue($argument = "", $default = false) {
        $this->defaultvalues[$argument] = $default;
    }

    /**
     * Set a parsed argument.
     *
     * @param $argument
     * @param $value
     */
    public function set($argument, $value)
    {
        $this->values[$argument] = $value;
    }

    /**
     * Return any set argument or false if the argument is unknown.
     *
     * @param $argument
     * @return bool
     */
    public function get($argument)
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
    public function all() {
        return $this->arguments;
    }

    /**
     * Add arugments to the list, this could be one or an array of arguments.
     *
     * @param $argument
     * @param array $options
     * @throws \Exception
     */
    public function add($argument, $options = [])
    {
        if (is_array($argument) === true) {
            $this->addMany($argument);
            return;
        }

        $options['name'] = $argument;
        $arg = new Argument($options);

        if (!($arg instanceof Argument)) {
            throw new \Exception('Please provide an argument name or object.');
        }
        $this->arguments[$argument] = $arg;
    }

    /**
     * This function will be called if we can add an array of commandline arguments
     * to parse.
     *
     * @param array $arguments
     * @throws \Exception
     */
    protected function addMany(array $arguments = [])
    {
        foreach ($arguments as $name => $options) {
            $this->add($name, $options);
        }
    }

    /**
     * Go ahead and parse the arguments given.
     *
     * @param array|null $argv
     * @throws \Exception
     */
    public function parse()
    {
        $this->parser->setFilter($this->filter, $this->all());
        $this->parser->parse();
    }
}