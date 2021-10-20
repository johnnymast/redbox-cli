<?php
/**
 * Parser.php
 *
 * This class parses the arguments.
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

/**
 * This class will parse the given arguments.
 *
 * @package Redbox\Cli\Arguments
 */
class Parser
{
    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var Manager
     */
    protected Manager $manager;

    /**
     * Parser constructor.
     *
     * @var array
     */
    protected array $arguments;

    /**
     * Parser constructor.
     *
     * @param Manager|null $manager Argument Manager.
     */
    public function __construct(Manager $manager = NULL)
    {
        $this->manager = $manager;
    }

    /**
     * Set the filter for the parser.
     *
     * @param Filter $filter    The Filter instance
     * @param array  $arguments The arguments array.
     */
    public function setFilter(Filter $filter, array $arguments = [])
    {
        $this->filter = $filter;
        $this->arguments = $arguments;
        $this->filter->setArguments($arguments);
    }

    /**
     * Return the script name.
     *
     * @return mixed
     */
    public function getCommand(): mixed
    {
        global $argv;
        return $argv[0];
    }

    /**
     * This is it, we parse the given arguments.
     *
     * @return void
     * @throws \Exception
     *
     */
    public function parse()
    {
        list($shortOptions, $longOptions) = $this->buildOptions();
        $results = getopt($shortOptions, $longOptions);

        foreach ($this->arguments as $argument) {
            $name = $argument->name;
            $value = '';

            if (isset($results[$argument->prefix]) || isset($results[$argument->longPrefix])) {
                $value = $results[$argument->prefix] ?? $results[$argument->longPrefix];
            } else {
                /**
                 * If we set the default value for this argument we also add it to
                 * the result array or it will fail the argument has the option required by mistake.
                 */
                if ($argument->defaultValue) {
                    $value = $argument->defaultValue;
                    $this->manager->setHasDefaultValue($name, true);
                    $results[$argument->name] = $value;
                } else {
                    if ($argument->required === true) {
                        throw new \Exception(
                            'The following arguments are required: '
                            . print_r($argument->name, true) . '.'
                        );
                    }
                }
            }
            $this->manager->set($name, $value);
        }
    }

    /**
     * Build the option arrays that could be used with getopt()
     *
     * @return array
     */
    private function buildOptions(): array
    {
        $short_prefixes = $this->filter->withShortPrefix();
        $long_prefixes = $this->filter->withLongPrefix();

        $short = '';
        $long = array();

        foreach ($short_prefixes as $argument) {
            $short .= $argument->prefix;
            $short .= ($argument->required == true) ? ':' : '::';
        }

        foreach ($long_prefixes as $argument) {
            $rule = $argument->longPrefix;
            if (strlen($rule) > 0) {
                $rule .= ($argument->required == true) ? ':' : '::';
                $long[] = $rule;
            }
        }
        return [$short, $long];
    }
}