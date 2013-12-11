<?php
/**
 * PHPUnit Bootstrap file.
 */

/**
 * Set `WP_TESTS_DIR` to the base directory of WordPress:
 * `svn export http://develop.svn.wordpress.org/trunk/ /tmp/wordpress-tests`
 *
 * Then add this to your bash environment:
 *
 * export WP_TESTS_DIR=/tmp/wordpress/tests
 */
if ( ! $wp_test_dir = getenv('WP_TESTS_DIR') ) {

    $wp_test_dir = realpath('../../../../');

    if ( ! file_exists($wp_test_dir) || ! file_exists($wp_test_dir . '/tests') ) {
        die("Fatal Error: Could not find the WordPress tests directory.\n");
    }
}

/**
 * Loads WP utility functions like `tests_add_filter` and `_delete_all_posts`.
 */
require_once $wp_test_dir . '/tests/phpunit/includes/functions.php';

/**
 * Composer Autoloader
 */
require_once getcwd() . '/vendor/autoload.php';

/**
 * Define custom settings in bootstrap-config.php.
 */
if ( file_exists(dirname(__FILE__) . '/bootstrap-config.php') ) {

    require_once dirname(__FILE__) . '/bootstrap-config.php';

} else {
    /**
     * Preset wp_options before loading the WordPress stack.
     *
     * Used to activate themes, plugins, as well as other settings in `wp_options`.
     *
     * @see wp_tests_options
     */
    $GLOBALS['wp_tests_options'] = [
        'active_plugins' => [
            'hello.php',
        ],
    ];

    /**
     * Do stuff during the `muplugins_loaded` action.
     */
    function __muplugins_loaded()
    {
        // code and stuff.
    }
    tests_add_filter( 'muplugins_loaded', '__muplugins_loaded');
}

/**
 * Bootstraps the WordPress stack.
 */
require $wp_test_dir . '/tests/phpunit/includes/bootstrap.php';

