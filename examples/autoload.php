<?php
/**
 * We want to make sure we load the correct autoloader
 * where ever we are. This will load the correct autoloader
 * if we are on local development or loaded as a component/package.111
 */
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    require_once __DIR__ . '/../../../autoload.php';
}
