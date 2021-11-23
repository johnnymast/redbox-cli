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

use Redbox\Cli\Output\OutputBuffer;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @package Redbox\Cli\Arguments
 *
 * @method addOption(string|null $name, ?string $prefix, int|null $options, string $description, string $default = null): Redbox\Cli\Arguments\Operation
 *
 *
 */
class Arguments
{

    public const DEFAULT_OPERATION = "default";

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
     * @var \Redbox\Cli\Output\OutputBuffer
     */
    private OutputBuffer $outputBuffer;

    /**
     * Arguments constructor.
     *
     * @throws \Exception
     */
    public function __construct(OutputBuffer $outputBuffer)
    {

        $this->registerOperation(self::DEFAULT_OPERATION,
            static fn(Operation $operation) => $operation->markAsDefault(), true);

        $this->parser = new Parser();
        $this->operation = $this->getOperation(self::DEFAULT_OPERATION);
        $this->outputBuffer = $outputBuffer;
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
     * Return the app description.
     *
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Create a new operation.
     *
     * @param string        $name     The name of the operation.
     * @param callable|null $callback An optional callback you can use to register options.
     * @param bool          $internal Flag for internal usage of this function
     *
     * @return \Redbox\Cli\Arguments\Operation
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
            $this->outputBuffer->addLine("{$command} - {$this->description}");
        } else {
            $this->outputBuffer->addLine($command);
        }

        $this->outputBuffer
            ->addNewLine()
            ->addNewLine();

        $longest = [
            'operation' => 0,
            'argument' => 0,
        ];

        $allOptions = [];
        $numOperations = count($this->operations);

        foreach ($this->operations as $name => $operation) {
            $options = $operation->getOptions();


            /**
             * For esthetics show the optional arguments first.
             */
            usort($options, static fn(Option $option) => $option->isRequired() ? 1 : 0);

            if (count($options) > 0) {

                if ($operation->isDefaultOperation()) {
                    $line = "usage: {$command} ";
                } else {
                    $line = "usage: {$command} {$name}";
                }

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

                $this->outputBuffer
                    ->addLine($line)
                    ->addNewLine();
            }

            $longest['operation'] = max(strlen($name), $longest['operation']);
        }

        $this->outputBuffer
            ->addNewLine()
            ->addLine("Options:")
            ->addNewLine()
            ->addNewLine();

        foreach ($allOptions as $option) {
            $description = $option->description;
            $operation = $option->getOperation();

            if ($operation->isDefaultOperation()) {
                $name = str_pad("", $longest['operation']);;
            } else {
                $name = str_pad($operation->name, $longest['operation']);
            }
            // TODO: Replace with columns

            $usage = str_pad($option->usageInfo(), $longest['argument']);

            $line = "{$command} {$name} {$usage}\t{$description}";

            $this->outputBuffer->addLine($line)
                ->addNewLine();
        }

        $this->outputBuffer
            ->addNewLine()
            ->addNewLine()
            ->show();
    }

    /**
     * Proxy calls to the default operation.
     *
     * @param string $name      The method
     * @param array<string>  $arguments Its arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this->operation, $name) === true) {
            return call_user_func_array([$this->operation, $name], $arguments);
        }

        return trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
    }
}