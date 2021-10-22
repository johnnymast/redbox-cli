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
use Redbox\Cli\Output\Output;
use Redbox\Cli\traits\KeyValueTrait;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @package Redbox\Cli\Arguments
 */
class Arguments
{
    use KeyValueTrait;

    const DEFAULT_OPERATION = "default";
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
     * @var \Redbox\Cli\Output\Output
     */
    private Output $output;

    /**
     * Arguments constructor.
     */

    public function __construct(Output $output)
    {

        $this->operation(self::DEFAULT_OPERATION,
            static fn(Operation $operation) => $operation->markAsDefault());

        $this->parser = new Parser();
        $this->operation = $this->getOperation(self::DEFAULT_OPERATION);
        $this->output = $output;
    }


    // NEW

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function operation(string $name, callable|null $callback = null): Arguments
    {
        $this->operations[$name] = new Operation($name);

        if (is_callable($callback) === true) {
            $callback($this->operations[$name]);
        }

        return $this;
    }

    /**
     * Return an operation.
     *
     * @param string $name The name of the operation.
     *
     * @return \Redbox\Cli\Arguments\Operation|false
     */
    public function getOperation(string $name): Operation|bool
    {
        if (isset($this->operations[$name]) === true) {
            return $this->operations[$name];
        }
        return false;
    }

    public function usage(): void
    {
        global $argv;
        //$command = $this->parser->getCommand();
        $command = $argv[0];

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

            if (count($options) > 0 || $operation->isDefaultOperation() === true) {
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

            // TODO: Replace with columns
            $name = str_pad($operation->name, $longest['operation']);
            $usage = str_pad($option->usageInfo(), $longest['argument']);

            $line = "{$command} {$name} {$usage}\t{$description}";

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
        return isset($this->defaultValues[$key]) === true;
    }

    /**
     * Set if a argument has defaulted to the default argument or not.
     *
     * @param string $key   - The argument name.
     * @param bool   $value - Set the value to this.
     *
     * @return void
     */
    public function setHasDefaultValue(string $key, bool $value): void
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
     * Go ahead and parse the arguments given.
     *
     * @return void
     * @throws \Exception
     */
    public function parse(): void
    {
        $this->parser->parse($this->operations);
    }

    /**
     * Proxy calls to the default operation.
     *
     * @param string $name      The method
     * @param array  $arguments Its arguments
     *
     * @return false|mixed|void
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->operation, $name) === true) {
            return call_user_func_array([$this->operation, $name], $arguments);
        }

        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}