<?php
/**
 * Plugin init files
 *
 * @package Plugin
 * @since 0.1.0
 */

namespace Plugin;

$plugin = new Plugin();
$plugin->register_hooks();

require_once( PLUGIN_DIR_PATH . 'src/inc/functions.php' );
