<?php
/**
 * Autoload.php
 *
 * We want to make sure we load the correct autoloader
 * where ever we are.
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
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    include_once __DIR__ . '/../vendor/autoload.php';
} else {
    include_once __DIR__ . '/../../../autoload.php';
}
