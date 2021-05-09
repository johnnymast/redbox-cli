<?php
/**
 * Filter.php
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

/**
 * Okay its hard to explain this one you dot not know array_filter.
 * What it does (this class)
 *
 * @category Core
 * @package  Redbox_Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-cli
 * @since    1.0
 */
class Filter
{
    /**
     * An array of arguments passed to the program.
     *
     * @var Argument[] $arguments
     */
    protected $arguments = [];

    /**
     * Set the arguments to filter.
     *
     * @param array $arguments The arguments.
     *
     * @return void
     */
    public function setArguments($arguments = []): void
    {
        $this->arguments = $arguments;
    }

    /**
     * Callback function to check if the argument has a short prefix.
     *
     * @param \Redbox\Cli\Arguments\Argument $argument The argument to check.
     *
     * @return mixed
     */
    public function hasShortPrefix($argument)
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument has a long prefix.
     *
     * @param \Redbox\Cli\Arguments\Argument $argument The argument to check.
     *
     * @return mixed
     */
    public function hasLongPrefix($argument)
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument is required.
     *
     * @param \Redbox\Cli\Arguments\Argument $argument The argument to check.
     *
     * @return bool
     */
    protected function isRequired($argument): bool
    {
        return ($argument->required == true);
    }

    /**
     * Callback function to check if the argument does not had the required option.
     *
     * @param \Redbox\Cli\Arguments\Argument $argument The argument to check.
     *
     * @return bool
     */
    protected function isOptional($argument): bool
    {
        return ($argument->required == false);
    }

    /**
     * Return all required arguments, these are arguments with required => true,
     *
     * @return Argument[] arguments with arguments set required to true
     */
    public function required(): array
    {
        return $this->filterArguments(['isRequired']);
    }

    /**
     * Return all arguments without required => true.
     *
     * @return Argument[] arguments with arguments set required to false
     */
    public function optional(): array
    {
        return $this->filterArguments(['isOptional']);
    }

    /**
     * Return an array with short prefixes.
     *
     * @return Argument[] arguments with a short prefix (e.x -u)
     */
    public function withShortPrefix(): array
    {
        return $this->filterArguments(['hasShortPrefix']);
    }

    /**
     * Return an array with long prefixes
     *
     * @return Argument[] required arguments (e.x --user)
     */
    public function withLongPrefix(): array
    {
        return $this->filterArguments(['hasLongPrefix']);
    }

    /**
     * This function will do the actual filtering. Call backs for array_filter
     * will be in this function for example isRequired.
     *
     * @param array $filters The filters for the arguments array.
     *
     * @return array
     */
    protected function filterArguments($filters = []): array
    {
        $arguments = $this->arguments;

        foreach ($filters as $filter) {
            $arguments = array_filter($arguments, [$this, $filter]);
        }
        return array_values($arguments);
    }
}
