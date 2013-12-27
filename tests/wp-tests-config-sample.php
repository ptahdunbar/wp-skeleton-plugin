<?php
/**
 * The tests configuration file for WordPress.
 */

/** Absolute path to the WordPress codebase. Add a backslash in the end. */
define('ABSPATH', '/tmp/wordpress/');

define('WP_TESTS_DOMAIN', 'example.org/wp');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Test Blog');

/** Absolute path to the wp-content directory. Add a backslash in the end. */
//define('WP_CONTENT_DIR', '/tmp/wordpress/content/');

/** Be sure to keep this constant updated if wp-content is custom. */
//define('WP_CONTENT_URL', 'http://' . WP_TESTS_DOMAIN . '/content');

/**
 * WARNING WARNING WARNING!
 *
 * ALL DATABASES TABLES WILL BE DROPPED, ONLY USE FOR TESTING.
 * DO NOT use a production database or one that is shared with something else.
 */

/** The name of the database for WordPress */
define('DB_NAME', 'youremptytestdbnamehere');

/** MySQL database username */
define('DB_USER', 'yourusernamehere');

/** MySQL database password */
define('DB_PASSWORD', 'yourpasswordhere');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a
 * unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wptests_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * Preset wp_options before loading the WordPress stack.
 *
 * Used to activate themes, plugins, as well as other settings in `wp_options`.
 *
 * @see wp_tests_options
 */
$GLOBALS['wp_tests_options'] = [
//    // 'option_name' => 'option_value',
    'active_plugins' => [
        'wp-skeleton-plugin/autoload.php',
    ],
    'timezone_string' => 'America/New_York',
];

/**#@-*/

/** Define the environment this configuration is configured to. */
define('WP_ENV', 'testing');

/** Test with WordPress debug mode (default). */
define('WP_DEBUG', true);

/** Disable minified scripts and styles and use full versions instead. */
define('SCRIPT_DEBUG', false);

/** Saves database queries for query analyzing. Not recommended for production. */
define('SAVEQUERIES', false);

/** Profile Request/Response time. */
define('REQUEST_MICROTIME', microtime(true));

/** Test with multisite enabled. */
define('WP_TESTS_MULTISITE', false);

/** PHP cli bin command. */
define('WP_PHP_BINARY', 'php');
