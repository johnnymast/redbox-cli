<?php

use Redbox\Cli\Output\OutputBuffer;

require('vendor/autoload.php');

function getFilesFromPath(string $path): array
{

    $files = [];

    foreach (new \DirectoryIterator($path) as $file) {
        if ($file->isDot() === true) {
            continue;
        }
        $files[] = $file->getPathname();
    }

    return $files;
}

function resolveRoutes(array $namespaces)
{
    $baseMap = 'Redbox\Cli\\';
    $srcFolder = __DIR__ . '/src';

    $validAttributes = [
        Redbox\Cli\Router\Attributes\Route::class,
        Redbox\Cli\Router\Attributes\ColorRoute::class
    ];

    foreach ($namespaces as $namespace) {
        $folder = $srcFolder . '/' . substr($namespace, strlen($baseMap));
        $files = getFilesFromPath($folder);

        if (count($files) > 0) {
            foreach ($files as $file) {
                $class = $namespace . '\\' . rtrim(basename($file), '.php');

                $reflectionClass = new \ReflectionClass($class);

                foreach ($reflectionClass->getMethods() as $method) {
                    $methodParameters = $method->getParameters();
                    $attributes = $method->getAttributes();

                    foreach ($attributes as $attribute) {
                        $instance = $attribute->newInstance();
                        if (!($instance instanceof \Redbox\Cli\Router\Attributes\BaseAttribute)) {
                            continue;
                        }

                        $params = '';
                        foreach ($methodParameters as $index => $parameter) {
                            if ($index < 2) {
                                continue;
                            }

                            if ($parameter->isDefaultValueAvailable() === true) {

                                $value = $parameter->getDefaultValue();
                                if ($parameter->getType() == 'string') {
                                    $value = "'{$value}'";
                                }

                                $params .= "{$parameter->getType()} \${$parameter->getName()} = {$value}, ";
                            } else {
                                $params .= "{$parameter->getType()} \${$parameter->getName()}, ";
                            }
                        }

                        $params = rtrim($params, ', ');
                        $routeName = $instance->getMethod();

//                        echo "@method {$routeName}({$params}): \Redbox\Cli\Output\OutputBuffer\n";
                        echo "@method \Redbox\Cli\Cli {$routeName}({$params})\n";
                    }
                }

            }
        }
        print_r($files);
    }
}

$routes = resolveRoutes([
    'Redbox\Cli\Styling'
]);

