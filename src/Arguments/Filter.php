<?php
/**
 * Filter.php
 *
 * Object containing information about the arguments.
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
 * Okay it's hard to explain this one you dot not know array_filter.
 * What it does (this class)
 *
 * @package Redbox\Cli\Arguments
 */
class Filter
{
    /**
     * An array of arguments passed to the program.
     *
     * @var array<\Redbox\Cli\Arguments\Argument> $arguments
     */
    protected array $arguments = [];

    /**
     * Set the arguments to filter.
     *
     * @param array<\Redbox\Cli\Arguments\Argument> $arguments
     */
    public function setArguments(array $arguments = [])
    {
        $this->arguments = $arguments;
    }

    /**
     * Callback function to check if the argument has a short prefix.
     *
     * @param Argument $argument The argument.
     *
     * @return bool
     */
    public function hasShortPrefix(Argument $argument): bool
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument has a long prefix.
     *
     * @param Argument $argument Check if this argument has a long prefix.
     *
     * @return bool
     */
    public function hasLongPrefix(Argument $argument): bool
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument is required.
     *
     * @param Argument $argument Check if this argument is required.
     *
     * @return bool
     */
    protected function isRequired(Argument $argument): bool
    {
        return $argument->required;
    }

    /**
     * Callback function to check if the argument does not had the required option.
     *
     * @param Argument $argument Check if this argument is optional.
     *
     * @return bool
     */
    protected function isOptional(Argument $argument): bool
    {
        return ($argument->required == false);
    }

    /**
     * Return all required arguments, these are arguments with required => true,
     *
     * @return array<array<\Redbox\Cli\Arguments\Argument>> arguments with arguments set required to true
     */
    public function required(): array
    {
        return $this->filterArguments(['isRequired']);
    }

    /**
     * Return all arguments without required => true.
     *
     * @return array<\Redbox\Cli\Arguments\Argument> arguments with arguments set required to false
     */
    public function optional(): array
    {
        return $this->filterArguments(['isOptional']);
    }

    /**
     * Return an array with short prefixes.
     *
     * @return array<\Redbox\Cli\Arguments\Argument> arguments with a short prefix (e.x -u)
     */
    public function withShortPrefix(): array
    {
        return $this->filterArguments(['hasShortPrefix']);
    }

    /**
     * Return an array with long prefixes
     *
     * @return array<\Redbox\Cli\Arguments\Argument> required arguments (e.x --user)
     */
    public function withLongPrefix(): array
    {
        return $this->filterArguments(['hasLongPrefix']);
    }

    /**
     * This function will do the actual filtering. Call backs for array_filter
     * will be in this function for example isRequired.
     *
     * @param array $filters The filters.
     *
     * @return array
     */
    protected function filterArguments(array $filters = []): array
    {
        $arguments = $this->arguments;

        foreach ($filters as $filter) {
            $arguments = array_filter($arguments, [$this, $filter]);
        }
        return array_values($arguments);
    }
}