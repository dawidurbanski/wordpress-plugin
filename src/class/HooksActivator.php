<?php
/**
 * HooksActivator is a class to register actions and filters
 * from dockblock annotations
 *
 * Use one of the following in method dockblock to
 * register an action or filter:
 *
 * @action hook_name priority
 * @filter filter_name priority
 *
 * @package Plugin
 */

namespace Plugin;

/**
 * Main plugin class
 */
class HooksActivator {

	/**
	 * Pattern for doc hooks
	 */
	protected const PATTERN = '#\* @(?P<type>filter|action|shortcode)\s+(?P<name>[a-z0-9\-\.\/_]+)(?:,\s+(?P<priority>\d+))?#';

	/**
	 * Add actions/filters from the method of a class based on DocBlock
	 *
	 * @param object $object The class object.
	 */
	public function add_doc_hooks( $object = null ) {

		if ( is_null( $object ) ) {
			$object = $this;
		}

		$class_name = get_class( $object );

		$this->_called_doc_hooks[ $class_name ] = true;
		$reflector = new \ReflectionObject( $object );

		foreach ( $reflector->getMethods() as $method ) {

			$doc       = $method->getDocComment();
			$arg_count = $method->getNumberOfParameters();

			if ( preg_match_all( self::PATTERN, $doc, $matches, PREG_SET_ORDER ) ) {

				foreach ( $matches as $match ) {

					$type = $match['type'];
					$name = $match['name'];

					$priority = empty( $match['priority'] ) ? 10 : intval( $match['priority'] );
					$callback = array( $object, $method->getName() );

					call_user_func( array( $this, "add_{$type}" ), $name, $callback, compact( 'priority', 'arg_count' ) );

				}
			}
		}
	}

	/**
	 * Hooks a function on to a specific filter
	 *
	 * @param string $name     The hook name.
	 * @param array  $callback The class object and method.
	 * @param array  $args     An array with priority and arg_count.
	 * @return mixed
	 */
	public function add_filter( $name, $callback, $args = array() ) {

		// Merge defaults.
		$args = array_merge(
			array(
				'priority' => 10,
				'arg_count' => PHP_INT_MAX,
			), $args
		);

		return $this->_add_hook( 'filter', $name, $callback, $args );

	}

	/**
	 * Hooks a function on to a specific action
	 *
	 * @param string $name     The hook name.
	 * @param array  $callback The class object and method.
	 * @param array  $args     An array with priority and arg_count.
	 * @return mixed
	 */
	public function add_action( $name, $callback, $args = array() ) {

		// Merge defaults.
		$args = array_merge(
			array(
				'priority' => 10,
				'arg_count' => PHP_INT_MAX,
			), $args
		);

		return $this->_add_hook( 'action', $name, $callback, $args );

	}

	/**
	 * Hooks a function on to a specific shortcode
	 *
	 * @param string $name     The shortcode name.
	 * @param array  $callback The class object and method.
	 * @return mixed
	 */
	public function add_shortcode( $name, $callback ) {
		return $this->_add_hook( 'shortcode', $name, $callback );
	}

	/**
	 * Hooks a function on to a specific action/filter
	 *
	 * @param string $type     The hook type. Options are action/filter.
	 * @param string $name     The hook name.
	 * @param array  $callback Callback.
	 * @param array  $args     An array with priority and arg_count.
	 * @return mixed
	 */
	protected function _add_hook( $type, $name, $callback, $args = array() ) {

		$priority = isset( $args['priority'] ) ? $args['priority'] : 10;
		$arg_count = isset( $args['arg_count'] ) ? $args['arg_count'] : PHP_INT_MAX;

		$function = sprintf( 'add_%s', $type );

		return call_user_func( $function, $name, $callback, $priority, $arg_count );

	}
}
