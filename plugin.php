<?php
/**
 * Plugin Name:     PLugin boilerplate
 * Author:          Dawid Urbański
 * Author URI:      http://webastik.pl
 * Text Domain:     plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Plugin_Package
 */

namespace Plugin;

/**
 * Change to unique names
 */
define( 'PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

/**
 * Require composer autoload
 */
require_once( PLUGIN_DIR_PATH . 'vendor/autoload.php' );

/**
 * Require plugin init file
 */
require_once( PLUGIN_DIR_PATH . 'src/inc/init.php' );
