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
 * @internal
 */
class Parser
{

    /**
     * Build the option arrays that could be used with getopt()
     *
     * @param \Redbox\Cli\Arguments\Operation $operation The operation
     *
     * @return array<int, array<int, string>|string>
     */
    private function buildOpts(Operation $operation): array
    {

        $shortPrefix = $operation->getOptionsWithShortPrefix();
        $longPrefix = $operation->getOptionsWithLongPrefix();

        $short = '';
        $long = [];

        foreach ($shortPrefix as $option) {
            $short .= $option->prefix;
            $short .= ($option->isRequired() === true) ? ':' : '::';
        }

        foreach ($longPrefix as $option) {
            $rule = $option->name;
            if ($rule !== '') {
                $rule .= ($option->isRequired() === true) ? ':' : '::';
                $long[] = $rule;
            }
        }
        return [$short, $long];
    }


    /**
     * Parse the options for all operations.
     *
     * @param array<string, \Redbox\Cli\Arguments\Operation> $operations all operations
     *
     * @throws \Exception
     */
    public function parse(array $operations): void
    {

        foreach ($operations as $operation) {

            if ($operation->hasOptions() === true) {

                [$shortOpts, $longOpts] = $this->buildOpts($operation);
                $results = getopt($shortOpts, $longOpts);

                $options = $operation->getOptions();


                foreach ($options as /* @var Option */ $option) {
                    $name = $option->name;

                    if (isset($results[$option->prefix]) || isset($results[$option->longPrefix])) {

                        $value = $results[$option->prefix] ?? $results[$option->longPrefix];
                        $operation->set($name, $value);

                    } else if ($option->hasDefaultValue()) {

                        $results[$option->name] = $option->getDefaultValue();
                        $operation->set($name, $option->getDefaultValue());

                    } else if ($option->isRequired() === true) {

                        throw new \Exception(
                            'The following options are required: '
                            . print_r($option->name, true) . '.'
                        );
                    }
                }
            }
        }
    }
}