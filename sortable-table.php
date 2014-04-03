<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Sortable_Table
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       Sortable Table
 * Plugin URI:        @TODO
 * Description:       Sortable Table
 * Version:           1.0.0
 * Author:            @TODO
 * Author URI:        @TODO
 * Text Domain:       sortable-table-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include 'ChromePhp.php';

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `sortable-table.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-sortable-table.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Sortable_Table with the name of the class defined in
 *   `sortable-table.php`
 */
register_activation_hook( __FILE__, array( 'Sortable_Table', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Sortable_Table', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Sortable_Table with the name of the class defined in
 *   `sortable-table.php`
 */
add_action( 'plugins_loaded', array( 'Sortable_Table', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-admin.php` with the name of the plugin's admin file
 * - replace Sortable_Table_Admin with the name of the class defined in
 *   `sortable-table-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sortable-table-admin.php' );
	add_action( 'plugins_loaded', array( 'Sortable_Table_Admin', 'get_instance' ) );

}
