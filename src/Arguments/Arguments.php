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

use Redbox\Cli\Output\Output;
use Redbox\Cli\Traits\KeyValueTrait;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @package Redbox\Cli\Arguments
 *
 * @method addOption(string|null $name, ?string $prefix, int|null $options, string $description, string $default =null): 'Redbox\Cli\Arguments\Operation
 *
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
    // protected array $arguments = [];

    /**
     * The app description.
     *
     * @var string
     */
    private string $description = '';

    /**
     * The default operation.
     *
     * @var \Redbox\Cli\Arguments\Operation
     */
    private Operation $operation;

    /**
     * @var array<string, \Redbox\Cli\Arguments\Operation>
     */
    private array $operations = [];

    /**
     * @var Parser
     */
    private Parser $parser;

    /**
     * @var \Redbox\Cli\Output\Output
     */
    private Output $output;

    /**
     * Arguments constructor.
     *
     * @throws \Exception
     */
    public function __construct(Output $output)
    {

        $this->registerOperation(self::DEFAULT_OPERATION,
            static fn(Operation $operation) => $operation->markAsDefault(), true);

        $this->parser = new Parser();
        $this->operation = $this->getOperation(self::DEFAULT_OPERATION);
        $this->output = $output;
    }

    /**
     * Set the app description.
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Create a new operation.
     *
     * @param string        $name     The name of the operation.
     * @param callable|null $callback An optional callback you can use to register options.
     * @param bool          $internal Flag for internal usage of this function
     *
     * @return $this
     * @throws \Exception
     */
    public function registerOperation(string $name, callable|null $callback = null, bool $internal = false): Operation
    {
        if (($internal === false) && $name === self::DEFAULT_OPERATION) {
            throw new \Exception("{name} is an reserved operation name.");
        }
        $this->operations[$name] = new Operation($name);

        if (is_callable($callback) === true) {
            $callback($this->operations[$name]);
        }

        return $this->operations[$name];
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
     * Print the usage information.
     */
    public function usage(): void
    {
        // FIXME: Make a function of this
        global $argv;
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