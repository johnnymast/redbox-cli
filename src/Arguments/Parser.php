<?php
/**
 * Parser.php
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

use Exception;

/**
 * This class will parse the given arguments.
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class Parser
{
    /**
     * The argument filter.
     *
     * @var \Redbox\Cli\Arguments\Filter
     */
    protected $filter;

    /**
     * The argument manager.
     *
     * @var \Redbox\Cli\Arguments\Manager
     */
    protected $manager;

    /**
     * Parser constructor.
     *
     * @var array
     */
    protected $arguments;

    /**
     * Parser constructor.
     *
     * @param Manager $manager The argument manager.
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Set the filter for the parser.
     *
     * @param Filter $filter    The argument filter.
     * @param array  $arguments The array containing the arguments.
     *
     * @return void
     */
    public function setFilter(Filter $filter, array $arguments = []): void
    {
        $this->filter = $filter;
        $this->arguments = $arguments;
        $this->filter->setArguments($arguments);
    }

    /**
     * Return the script name.
     *
     * @return string
     */
    public function getCommand(): string
    {
        global $argv;
        return $argv[0];
    }

    /**
     * This is it, we parse the given arguments.
     *
     * @return void
     * @throws \Exception
     */
    public function parse(): void
    {
        list($shortOptions, $longOptions) = $this->_buildOptions();
        $results = getopt($shortOptions, $longOptions);

        foreach ($this->arguments as $argument) {
            $name = $argument->name;
            $value = '';

            if (isset($results[$argument->prefix])
                || isset($results[$argument->longPrefix])
            ) {
                // @codingStandardsIgnoreStart
                $value = $results[$argument->prefix] ?? $results[$argument->longPrefix];
                // @codingStandardsIgnoreEnd
            } else {

                /**
                 * If we set the default value for this argument we also add it to
                 * the result array or it will fail the argument has the option
                 * required by mistake.
                 */
                if ($argument->defaultValue) {
                    $value = $argument->defaultValue;
                    $this->manager->setHasDefaultValue($name, true);
                    $results[$argument->name] = $value;
                } else {
                    if ($argument->required === true) {
                        throw new Exception(
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
    private function _buildOptions(): array
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
