<?php
/**
 * Main plugin class file
 *
 * @package Plugin
 */

namespace Plugin;

/**
 * Main plugin class
 */
class Plugin extends Abstracts\WPIntegrator implements Interfaces\Hookable {

	/**
	 * Init plugin
	 *
	 * @action plugins_loaded
	 *
	 * @return void
	 */
	public function plugin_init() {
		die();
	}
}
