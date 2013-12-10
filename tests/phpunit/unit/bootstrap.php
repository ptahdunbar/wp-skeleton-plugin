<?php
/**
 * PHPUnit Bootstrap file.
 */

/**
 * Composer Autoloader
 */
require_once 'vendor/autoload.php';

/**
 * Define custom settings in bootstrap-config.php.
 */
if ( file_exists(dirname(__FILE__) . '/bootstrap-config.php') ) {

    require_once dirname(__FILE__) . '/bootstrap-config.php';

}