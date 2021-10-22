<?php
/**
 * Argument.php
 *
 * This class manages the arguments passed to the application.
 *
 * PHP version ^8.0
 *
 * @category Arguments
 * @package  Redbox-Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  1.5
 * @link     https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md
 * @since    1.0
 */

namespace Redbox\Cli\Arguments;

use JetBrains\PhpStorm\Pure;
use Redbox\Cli\Attributes\Inject;
use Redbox\Cli\Output\Output;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @package Redbox\Cli\Arguments
 */
class Manager
{
    /**
     * An array of arguments passed to the program.
     *
     * @var array<Argument> $arguments
     */
    protected array $arguments = [];

    protected string $description = '';

    protected Operation $operation;

    /**
     * @var array<string, \Redbox\Cli\Arguments\Operation>
     */
    protected array $operations = [];

    /**
     * An array containing the parsed values.
     *
     * @var array<string> $values
     */
    protected array $values = [];

    /**
     * An array that contains all the default values
     * that are passed to the manager.
     *
     * @var array<string>
     */
    protected array $defaultValues = [];

    /**
     * @var ?Parser
     */
    protected ?Parser $parser = null;

    /**
     * @var ?Filter
     */
    protected ?Filter $filter = null;

    /**
     * Manager constructor.
     */

    public function __construct(Output $output)
    {

        $this->operation('');

        $this->output = new Output();
        $this->parser = new Parser($this);
        $this->filter = new Filter;
    }

    /**
     * Prints out the usage message to the user.
     *
     * @return void
     */
    public function usage()
    {
        $requiredArguments = $this->filter->required();
        $optionalArguments = $this->filter->optional();
        $allArguments = array_merge($requiredArguments, $optionalArguments);
        $command = $this->parser->getCommand();
        $args = array();

        $num_required = count($requiredArguments);
        $num_optional = count($optionalArguments);

        if ($this->description !== '') {
            echo "{$command} - {$this->description}\n\n";
        } else {
            echo "{$command}\n\n";
        }

        echo "usage: " . $command . " ";

        foreach ($allArguments as $argument) {
            /** @var Argument $argument */
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

    // NEW

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function operation(string $name, callable|null $callback = null): Manager
    {
        $this->operations[$name] = new Operation($name);

        if (is_callable($callback) === true) {
            $callback($this->operations[$name]);
        }

        return $this;
    }

    public function newUsage(): void
    {
        $command = $this->parser->getCommand();

        if ($this->description !== '') {
            $this->output->addLine("{$command} - {$this->description}");
        } else {
            $this->output->addLine($command);
        }

        $this->output
            ->addNewLine()
            ->addNewLine();

        $longest = [
            'operation' => 0,
            'argument' => 0,
        ];

        $allOptions = [];

        foreach ($this->operations as $name => $operation) {
            $options = $operation->getOptions();
            $line = "usage: {$command} {$name}";

            /**
             * For esthetics show the optional arguments first.
             */
            usort($options, static fn(Option $option) => $option->isRequired() ? 1 : 0);

            if (count($options) > 0) {
                foreach ($options as $option) {
                    $line .= " ";

                    if ($option->isOptional()) {
                        $line .= '[' . $option->usageInfo() . ']';
                    } elseif ($option->isRequired()) {
                        $line .= $option->usageInfo();
                    }

                    $longest['argument'] = max(strlen($option->usageInfo()), $longest['argument']);
                    $allOptions[] = $option;
                }
                $this->output
                    ->addLine($line)
                    ->addNewLine();
            }

            $longest['operation'] = max(strlen($name), $longest['operation']);
        }

        $this->output
            ->addNewLine()
            ->addLine("Options:")
            ->addNewLine()
            ->addNewLine();

        foreach ($allOptions as $option) {
            $description = $option->description;
            $operation = $option->getOperation();
            $operationName = $operation->name;

            $opName = str_pad($operationName, $longest['operation']);
            $usage = str_pad($option->usageInfo(), $longest['argument']);

            $line = "{$command} {$opName} {$usage}\t{$description}";

            $this->output->addLine($line)
                ->addNewLine();
        }

        $this->output
            ->addNewLine()
            ->addNewLine()
            ->output();
    }
    // EOF NEW

    /**
     * Determine if a given argument has a default value or not.
     * One thing to note is that if having no info about the argument
     * (being a key in xx is not set) we will return false as well.
     *
     * @param string $key - The argument name.
     *
     * @return bool
     */
    public function hasDefaultValue(string $key): bool
    {
        if (isset($this->defaultValues[$key]) === true) {
            return true;
        }
        return false;
    }

    /**
     * Set if a argument has defaulted to the default argument or not.
     *
     * @param string $key   - The argument name.
     * @param bool   $value - Set the value to this.
     *
     * @return void
     */
    public function setHasDefaultValue(string $key = "", $value = false): void
    {
        $this->defaultValues[$key] = $value;
    }

    /**
     * Get the default value for a argument.
     *
     * @param string $key - The argument name.
     *
     * @return mixed
     */
    public function getDefaultValue(string $key): mixed
    {
        if ($this->hasDefaultValue($key)) {
            return $this->get($key);
        }

        return false;
    }

    /**
     * Check to see if a argument is used.
     *
     * @param string $key - The name of the argument.
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return (isset($this->values[$key]));
    }

    /**
     * Set a parsed argument.
     *
     * @param string $key   - The name of the argument.
     * @param mixed  $value - Set the value to this.
     *
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * Return any set argument or false if the argument is unknown.
     *
     * @param string $key - The name of the argument.
     *
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if (isset($this->values[$key]) === true) {
            return $this->values[$key];
        }

        return false;
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
     * Add arguments to the list, this could be one or an array of arguments.
     *
     * @param string|array $name - The name of the argument.
     * @param array        $options
     *
     * @return void
     * @throws \Exception
     */
    public function add(string|array $name, array $options = []): void
    {
        if (is_array($name) === true) {
            $this->addMany($name);
            return;
        }

        $options['name'] = $name;
        $arg = new Argument($options);

        $this->arguments[$name] = $arg;
    }

    /**
     * This function will be called if we can add an array of commandline arguments
     * to parse.
     *
     * @param array $items - All the options to add.
     *
     * @return void
     * @throws \Exception
     */
    protected function addMany(array $items = []): void
    {
        foreach ($items as $name => $options) {
            $this->add($name, $options);
        }
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