<?php
/**
 * Interface for objects that can be used with hooks activator

 * @package Plugin
 */

namespace Plugin\Interfaces;

/**
 * Hookable interface
 */
interface Hookable {

	/**
	 * Register all hooks applied in given class
	 *
	 * @return void
	 */
	public function register_hooks();

}
