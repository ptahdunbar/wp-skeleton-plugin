<?php
 /**
 * Plugin Name: WP Skeleton Plugin
 * Plugin URI: https://github.com/ptahdunbar/wp-skeleton-plugin
 * Description: A walking skeleton WordPress plugin. -_O
 * Version: 0.0.1
 * Author: Ptah Dunbar
 * Author URI: http://ptahdunbar.com
 * Text Domain: wp-skeleton-plugin
 * Domain Path: languages/
 * GitHub Plugin URI: <owner>/<repo>
 * GitHub Branch: master
 * License: GPL2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/** Load composer */
$composer = dirname(__FILE__) . '/vendor/autoload.php';
if ( file_exists($composer) ) {
    require_once $composer;
}
