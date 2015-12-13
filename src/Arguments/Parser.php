<?php
namespace Redbox\Cli\Arguments;


class Parser {

    /**
     * @var \Redbox\Cli\Arguments\Filter $filter;
     */
    protected $filter;

    /**
     * @var \Redbox\Cli\Arguments\Manager $manager;
     */
    protected $manager;

    /**
     * Parser constructor.
     * @var \Redbox\Cli\Arguments\Argument $arguments;
     */
    protected $arguments;

    /**
     * Parser constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager = NULL)
    {
        $this->manager = $manager;
    }

    /**
     * Set the filter for the parser.
     *
     * @param Filter $filter
     * @param Array[] $arguments
     */
    public function setFilter(Filter $filter, array $arguments = []) {
        $this->filter    = $filter;
        $this->arguments = $arguments;
        $this->filter->setArguments($arguments);
    }

    /**
     * Return the script name.
     *
     * @return mixed
     */
    public function getCommand() {
        global $argv;
        return $argv[0];
    }

    /**
     * This is it, we parse the given arguments.
     *
     * @param array|null $argv
     * @throws \Exception
     */
    public function parse(array $argv = null)
    {
        /**
         * We need to do this so our Unit test will work.
         */
        if ($argv == null) {
            global $argv;
        }

        $requiredArguments  = $this->filter->required();
        list($shortOptions, $longOptions) = $this->buildOptions();

        $results = getopt($shortOptions, $longOptions);

        foreach ($this->arguments as $argument) {
            if (isset($results[$argument->prefix])) {
                $this->manager->set($argument->name, $results[$argument->prefix]);
            } elseif (isset($results[$argument->longPrefix])) {
                $this->manager->set($argument->name, $results[$argument->longPrefix]);
            } else {
                /**
                 * If we set the default value for this argument we also add it to
                 * the result array or it will fail the argument has the option required by mistake.
                 *
                 * If you think i should not do this please report it on the boards and explain why.
                 * (I'm a little in doubt here)
                 */
                if ($argument->defaultValue) {
                    $this->manager->set($argument->name, $argument->defaultValue);
                    $results[$argument->name] = $this->manager->get($argument->name);
                }
            }
        }


        foreach ($requiredArguments as $argument) {
            if (isset($results[$argument->prefix]) == false and isset($results[$argument->longPrefix]) == false) {
                throw new \Exception(
                    'The following arguments are required: '
                    . print_r($argument->name, true) . '.'
                );
            }
        }
    }

    /**
     * Build the option arrays that could be used with getopt
     *
     * @return array
     */
    private function buildOptions()
    {
        $short_prefixes = $this->filter->withShortPrefix();
        $long_prefixes  = $this->filter->withLongPrefix();

        $short = '';
        $long  = array();

        foreach($short_prefixes as $argument) {
            $short .= $argument->prefix;
            if ($argument->required) {
                $short .= ':';
            } elseif ($argument->required == false) {
                $short .= '::';
            }
        }

        foreach($long_prefixes as $argument) {
            $rule = $argument->longPrefix;
            if ($argument->required) {
                $rule .= ':';
            } elseif ($argument->required == false) {
                $rule .= '::';
            }
            $long[] = $rule;
        }
        return [$short, $long];
    }
}