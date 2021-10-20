<?php
/**
 * Router.php
 *
 * The router can take instances of classes or full classnames and read routes from
 * the objects.
 *
 * PHP version ^8.0
 *
 * @category Core
 * @package  Redbox-Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  1.5
 * @link     https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md
 * @since    1.5
 */

namespace Redbox\Cli;

use ReflectionClass;

/**
 * Class Router
 */
class Router
{

    /**
     * Container for the existing commands.
     *
     * @var array<string, object>
     */
    protected array $routes = [];

    /**
     * @param \Redbox\Cli\Cli $cli
     */
    public function __construct(protected Cli $cli)
    {
    }

    /**
     * Add a new route to the router.
     *
     * @param string|object $route class instance or full classname including namespace.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function addRoute(string|object $route)
    {
        $this->resolveMethods($route);
    }

    /**
     * Add many routes at once.
     *
     * @param array $routes array of classes containing potential routes.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function addManyRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    /**
     * Check to see if a route by name exists.
     *
     * @param string $route The name of a route.
     *
     * @return bool
     */
    public function hasRoute(string $route = ''): bool
    {
        return isset($this->routes[$route]);
    }

    /**
     * Return a route by name.
     *
     * @param string $route The name of the route.
     *
     * @return mixed
     */
    public function getRoute(string $route): mixed
    {
        return $this->routes[$route] ?? NULL;
    }

    /**
     * Return all known routes.
     *
     * @return object[]
     */
    public function getAllRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Run the callable of this route.
     *
     * @param string $route     The name of the route.
     * @param mixed  $arguments The arguments for the route.
     *
     * @return \Redbox\Cli\Cli
     */
    public function execute(string $route, mixed $arguments): Cli
    {
        if ($this->hasRoute($route)) {
            $route = $this->getRoute($route);

            call_user_func_array($route['callable'], [$this->cli->getOutput(), $route['info'], ...$arguments]);
        }

        return $this->cli;
    }

    /**
     * Parse the methods on the added classes to see if
     * we have potential routes.
     *
     * @throws \ReflectionException
     */
    private function resolveMethods(string|object $subject)
    {

        $reflectionClass = new ReflectionClass($subject);

        if (is_string($subject) === true) {
            $subject = $reflectionClass->newInstance();
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = $method->getAttributes();

            foreach ($attributes as $attribute) {
                $info = $attribute->newInstance();

                $this->routes[$info->getmethod()] = [
                    'info' => $info,
                    'callable' => [$subject, $method->getName()]
                ];
            }
        }
    }
}